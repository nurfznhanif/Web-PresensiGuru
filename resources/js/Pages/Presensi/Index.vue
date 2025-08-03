<template>
  <AppLayout>
    <div class="py-8 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
          <h1
            class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-2"
          >
            {{ isAdmin ? "Data Presensi Guru" : "Presensi Saya" }}
          </h1>
          <p class="text-slate-600">
            {{
              isAdmin
                ? "Kelola data presensi seluruh guru"
                : "Catat kehadiran Anda hari ini"
            }}
          </p>
        </div>

        <!-- Guru Presensi Section -->
        <div v-if="!isAdmin" class="mb-8">
          <div
            class="bg-white/80 backdrop-blur-lg shadow-xl rounded-3xl p-8 border border-white/20"
          >
            <!-- Current Time -->
            <div class="text-center mb-6">
              <div
                class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-100 to-cyan-100 px-6 py-3 rounded-2xl"
              >
                <svg
                  class="w-5 h-5 text-blue-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                <span class="text-lg font-semibold text-slate-700">{{
                  currentTime
                }}</span>
              </div>
            </div>

            <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">
              Presensi Hari Ini
            </h2>

            <!-- Location Info Card -->
            <div
              class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-6 mb-6"
            >
              <div class="flex items-start space-x-4">
                <div
                  class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0"
                >
                  <svg
                    class="w-6 h-6 text-white"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                  </svg>
                </div>
                <div class="flex-1">
                  <h3 class="font-bold text-amber-800 text-lg mb-2">
                    Informasi Lokasi Absensi
                  </h3>
                  <div class="space-y-2 text-amber-700">
                    <p>
                      <span class="font-semibold">{{
                        pengaturan?.nama_lokasi || "Lokasi Belum Diatur"
                      }}</span>
                    </p>
                    <p class="text-sm">
                      {{ pengaturan?.alamat_lokasi || "Alamat belum diatur" }}
                    </p>
                    <p class="text-sm">
                      Radius absensi:
                      <span class="font-semibold"
                        >{{ pengaturan?.radius_absensi || 100 }} meter</span
                      >
                    </p>
                  </div>

                  <!-- Location Status -->
                  <div class="mt-4 flex items-center space-x-3">
                    <div
                      :class="locationStatus.class"
                      class="px-4 py-2 rounded-xl text-sm font-semibold flex items-center space-x-2"
                    >
                      <div
                        class="w-2 h-2 rounded-full bg-current animate-pulse"
                      ></div>
                      <span>{{ locationStatus.text }}</span>
                    </div>
                    <button
                      @click="getCurrentLocation"
                      :disabled="gettingLocation"
                      class="flex items-center space-x-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-xl transition-all duration-300 transform hover:scale-105 disabled:opacity-50"
                    >
                      <svg
                        class="w-4 h-4"
                        :class="{ 'animate-spin': gettingLocation }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                        />
                      </svg>
                      <span>{{
                        gettingLocation ? "Mengambil..." : "Refresh Lokasi"
                      }}</span>
                    </button>
                  </div>

                  <!-- Debug Location Info -->
                  <div
                    v-if="userLocation.latitude"
                    class="mt-4 p-3 bg-blue-50 rounded-xl text-xs text-blue-700"
                  >
                    <p>
                      <strong>Lokasi Anda:</strong>
                      {{ userLocation.latitude.toFixed(6) }},
                      {{ userLocation.longitude.toFixed(6) }}
                    </p>
                    <p v-if="pengaturan?.latitude_sekolah">
                      <strong>Lokasi Sekolah:</strong>
                      {{ pengaturan.latitude_sekolah }},
                      {{ pengaturan.longitude_sekolah }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Current Attendance Status -->
            <div
              v-if="presensiHariIni"
              class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-6 mb-6"
            >
              <div class="flex items-center space-x-4">
                <div
                  class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center"
                >
                  <svg
                    class="w-6 h-6 text-white"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
                <div>
                  <h3 class="font-bold text-green-800 text-lg">
                    Status Presensi Hari Ini
                  </h3>
                  <div class="space-y-1 text-green-700">
                    <p>
                      <strong>Status Masuk:</strong>
                      {{ formatStatus(presensiHariIni.status_masuk) }}
                    </p>
                    <p v-if="presensiHariIni.jam_masuk">
                      <strong>Jam Masuk:</strong>
                      {{ presensiHariIni.jam_masuk }}
                    </p>
                    <p v-if="presensiHariIni.jam_pulang">
                      <strong>Jam Pulang:</strong>
                      {{ presensiHariIni.jam_pulang }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Attendance Forms -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
              <!-- Check In Form -->
              <div
                class="bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-200 rounded-2xl p-6"
              >
                <div class="flex items-center space-x-3 mb-4">
                  <div
                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center"
                  >
                    <svg
                      class="w-5 h-5 text-white"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                      />
                    </svg>
                  </div>
                  <h3 class="font-bold text-blue-800 text-lg">
                    Presensi Masuk
                  </h3>
                </div>

                <!-- Predicted Status -->
                <div class="mb-4 p-3 bg-white/60 rounded-xl">
                  <p class="text-sm font-medium text-slate-600 mb-1">
                    Status Prediksi:
                  </p>
                  <span
                    :class="predictedStatus.class"
                    class="px-3 py-1 text-sm font-semibold rounded-lg"
                  >
                    {{ predictedStatus.text }}
                  </span>
                </div>

                <form @submit.prevent="submitPresensi('masuk')">
                  <button
                    type="submit"
                    :disabled="
                      formMasuk.processing ||
                      (presensiHariIni && presensiHariIni.jam_masuk) ||
                      !userLocation.latitude
                    "
                    class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 disabled:from-gray-400 disabled:to-gray-400 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 disabled:transform-none disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                  >
                    <svg
                      class="w-5 h-5"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                    <span>
                      {{
                        presensiHariIni && presensiHariIni.jam_masuk
                          ? "Sudah Presensi Masuk"
                          : !userLocation.latitude
                          ? "Ambil Lokasi Dulu"
                          : gettingLocation
                          ? "Mengambil Lokasi..."
                          : "Presensi Masuk"
                      }}
                    </span>
                  </button>
                </form>
              </div>

              <!-- Check Out Form -->
              <div
                class="bg-gradient-to-br from-emerald-50 to-green-50 border border-emerald-200 rounded-2xl p-6"
              >
                <div class="flex items-center space-x-3 mb-4">
                  <div
                    class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-500 rounded-xl flex items-center justify-center"
                  >
                    <svg
                      class="w-5 h-5 text-white"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                      />
                    </svg>
                  </div>
                  <h3 class="font-bold text-emerald-800 text-lg">
                    Presensi Pulang
                  </h3>
                </div>

                <div class="mb-4 p-3 bg-white/60 rounded-xl">
                  <p class="text-sm text-slate-600">
                    Presensi pulang tersedia setelah melakukan presensi masuk
                  </p>
                </div>

                <form @submit.prevent="submitPresensi('pulang')">
                  <button
                    type="submit"
                    :disabled="
                      formPulang.processing ||
                      !(presensiHariIni && presensiHariIni.jam_masuk) ||
                      (presensiHariIni && presensiHariIni.jam_pulang) ||
                      !userLocation.latitude
                    "
                    class="w-full bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 disabled:from-gray-400 disabled:to-gray-400 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 disabled:transform-none disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                  >
                    <svg
                      class="w-5 h-5"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                      />
                    </svg>
                    <span>
                      {{
                        !(presensiHariIni && presensiHariIni.jam_masuk)
                          ? "Presensi Masuk Dulu"
                          : presensiHariIni && presensiHariIni.jam_pulang
                          ? "Sudah Presensi Pulang"
                          : !userLocation.latitude
                          ? "Ambil Lokasi Dulu"
                          : gettingLocation
                          ? "Mengambil Lokasi..."
                          : "Presensi Pulang"
                      }}
                    </span>
                  </button>
                </form>
              </div>
            </div>

            <!-- Working Hours Info -->
            <div
              class="bg-gradient-to-br from-slate-50 to-gray-50 border border-slate-200 rounded-2xl p-6"
            >
              <h3
                class="font-bold text-slate-800 text-lg mb-4 flex items-center"
              >
                <svg
                  class="w-5 h-5 mr-2 text-slate-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                Informasi Jam Kerja
              </h3>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div
                  class="text-center p-4 bg-white rounded-xl border border-green-200"
                >
                  <div
                    class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2"
                  >
                    <svg
                      class="w-4 h-4 text-green-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </div>
                  <p class="font-semibold text-green-600 text-sm">
                    Jam Masuk Normal
                  </p>
                  <p class="text-lg font-bold text-slate-800">
                    {{ formatTime(pengaturan?.jam_masuk_normal) || "08:00" }}
                  </p>
                </div>
                <div
                  class="text-center p-4 bg-white rounded-xl border border-yellow-200"
                >
                  <div
                    class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-2"
                  >
                    <svg
                      class="w-4 h-4 text-yellow-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </div>
                  <p class="font-semibold text-yellow-600 text-sm">
                    Batas Telat
                  </p>
                  <p class="text-lg font-bold text-slate-800">
                    {{ formatTime(pengaturan?.jam_masuk_telat) || "08:30" }}
                  </p>
                </div>
                <div
                  class="text-center p-4 bg-white rounded-xl border border-blue-200"
                >
                  <div
                    class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2"
                  >
                    <svg
                      class="w-4 h-4 text-blue-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7"
                      />
                    </svg>
                  </div>
                  <p class="font-semibold text-blue-600 text-sm">Jam Pulang</p>
                  <p class="text-lg font-bold text-slate-800">
                    {{ formatTime(pengaturan?.jam_pulang_normal) || "16:00" }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Attendance Data Table -->
        <div
          class="bg-white/80 backdrop-blur-lg shadow-xl rounded-3xl border border-white/20 overflow-hidden"
        >
          <div class="p-6 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-800 flex items-center">
              <svg
                class="w-6 h-6 mr-3 text-blue-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"
                />
              </svg>
              Riwayat Presensi
            </h2>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
              <thead class="bg-gradient-to-r from-slate-50 to-gray-50">
                <tr>
                  <th
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Tanggal
                  </th>
                  <th
                    v-if="isAdmin"
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Nama Guru
                  </th>
                  <th
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Jam Masuk
                  </th>
                  <th
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Status Masuk
                  </th>
                  <th
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Jam Pulang
                  </th>
                  <th
                    v-if="isAdmin"
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Lokasi
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-slate-100">
                <tr
                  v-for="item in presensi.data"
                  :key="item.id"
                  class="hover:bg-slate-50 transition-colors duration-200"
                >
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-xl flex items-center justify-center mr-3"
                      >
                        <svg
                          class="w-5 h-5 text-blue-600"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                          />
                        </svg>
                      </div>
                      <div>
                        <div class="text-sm font-semibold text-slate-900">
                          {{ formatDateCorrect(item.tanggal) }}
                        </div>
                        <div class="text-xs text-slate-500">
                          {{
                            new Date(item.tanggal).toLocaleDateString("id-ID", {
                              weekday: "short",
                            })
                          }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td v-if="isAdmin" class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div
                        class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white font-semibold text-sm mr-3"
                      >
                        {{
                          item.user
                            ? item.user.name.charAt(0).toUpperCase()
                            : "?"
                        }}
                      </div>
                      <div class="text-sm font-medium text-slate-900">
                        {{ item.user ? item.user.name : "N/A" }}
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <svg
                        class="w-4 h-4 text-green-500 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M11 16l-4-4m0 0l4-4m-4 4h14"
                        />
                      </svg>
                      <span class="text-sm font-medium text-slate-900">{{
                        item.jam_masuk || "-"
                      }}</span>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      :class="getStatusClass(item.status_masuk)"
                      class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
                    >
                      <div class="w-2 h-2 rounded-full bg-current mr-2"></div>
                      {{ formatStatus(item.status_masuk) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <svg
                        class="w-4 h-4 text-blue-500 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7"
                        />
                      </svg>
                      <span class="text-sm font-medium text-slate-900">{{
                        item.jam_pulang || "-"
                      }}</span>
                    </div>
                  </td>
                  <td v-if="isAdmin" class="px-6 py-4 whitespace-nowrap">
                    <div v-if="item.latitude_masuk">
                      <button
                        @click="showLocationModal(item)"
                        class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium rounded-lg transition-colors duration-200"
                      >
                        <svg
                          class="w-3 h-3 mr-1"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                          />
                        </svg>
                        Lihat Lokasi
                      </button>
                    </div>
                    <span v-else class="text-slate-400 text-sm">-</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- No Data State -->
          <div
            v-if="presensi.data && presensi.data.length === 0"
            class="text-center py-12"
          >
            <div
              class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4"
            >
              <svg
                class="w-10 h-10 text-slate-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"
                />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-600 mb-2">
              Belum Ada Data Presensi
            </h3>
            <p class="text-slate-500">Mulai catat kehadiran Anda hari ini</p>
          </div>
        </div>

        <!-- Location Modal -->
        <div
          v-if="showLocationInfo"
          class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4"
        >
          <div
            class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full mx-auto transform transition-all duration-300 scale-100"
          >
            <div class="p-6">
              <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-800 flex items-center">
                  <svg
                    class="w-6 h-6 text-blue-600 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                    />
                  </svg>
                  Detail Lokasi Presensi
                </h3>
                <button
                  @click="showLocationInfo = false"
                  class="w-8 h-8 bg-slate-100 hover:bg-slate-200 rounded-lg flex items-center justify-center transition-colors"
                >
                  <svg
                    class="w-5 h-5 text-slate-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </div>

              <div class="space-y-4">
                <div
                  class="bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-2xl border border-blue-100"
                >
                  <div class="flex items-center space-x-3 mb-3">
                    <div
                      class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center"
                    >
                      <svg
                        class="w-4 h-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                      </svg>
                    </div>
                    <div>
                      <p class="font-semibold text-blue-800">Tanggal</p>
                      <p class="text-sm text-blue-600">
                        {{ formatDateCorrect(selectedPresensi?.tanggal) }}
                      </p>
                    </div>
                  </div>
                </div>

                <div
                  class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-2xl border border-purple-100"
                >
                  <div class="flex items-center space-x-3 mb-3">
                    <div
                      class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center"
                    >
                      <svg
                        class="w-4 h-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />
                      </svg>
                    </div>
                    <div>
                      <p class="font-semibold text-purple-800">Nama Guru</p>
                      <p class="text-sm text-purple-600">
                        {{ selectedPresensi?.user?.name }}
                      </p>
                    </div>
                  </div>
                </div>

                <div
                  v-if="selectedPresensi?.latitude_masuk"
                  class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-2xl border border-green-100"
                >
                  <div class="flex items-center space-x-3 mb-3">
                    <div
                      class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center"
                    >
                      <svg
                        class="w-4 h-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M11 16l-4-4m0 0l4-4m-4 4h14"
                        />
                      </svg>
                    </div>
                    <div>
                      <p class="font-semibold text-green-800">Lokasi Masuk</p>
                      <p class="text-sm text-green-600 font-mono">
                        {{ selectedPresensi.latitude_masuk }},
                        {{ selectedPresensi.longitude_masuk }}
                      </p>
                    </div>
                  </div>
                </div>

                <div
                  v-if="selectedPresensi?.latitude_pulang"
                  class="bg-gradient-to-br from-orange-50 to-red-50 p-4 rounded-2xl border border-orange-100"
                >
                  <div class="flex items-center space-x-3 mb-3">
                    <div
                      class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center"
                    >
                      <svg
                        class="w-4 h-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7"
                        />
                      </svg>
                    </div>
                    <div>
                      <p class="font-semibold text-orange-800">Lokasi Pulang</p>
                      <p class="text-sm text-orange-600 font-mono">
                        {{ selectedPresensi.latitude_pulang }},
                        {{ selectedPresensi.longitude_pulang }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-6 flex justify-end">
                <button
                  @click="showLocationInfo = false"
                  class="px-6 py-2 bg-gradient-to-r from-slate-500 to-slate-600 hover:from-slate-600 hover:to-slate-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105"
                >
                  Tutup
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, computed, onMounted, onUnmounted } from "vue";

export default {
  components: {
    AppLayout,
  },
  props: {
    presensi: {
      type: Object,
      default: () => ({ data: [] }),
    },
    presensiHariIni: {
      type: Object,
      default: null,
    },
    isAdmin: {
      type: Boolean,
      default: false,
    },
    pengaturan: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    const userLocation = ref({ latitude: null, longitude: null });
    const gettingLocation = ref(false);
    const showLocationInfo = ref(false);
    const selectedPresensi = ref(null);
    const currentTime = ref("");

    const formMasuk = useForm({
      type: "masuk",
      status: "masuk",
      latitude: null,
      longitude: null,
    });

    const formPulang = useForm({
      type: "pulang",
      latitude: null,
      longitude: null,
    });

    // Status lokasi
    const locationStatus = computed(() => {
      if (!userLocation.value.latitude) {
        return {
          text: "Lokasi belum dideteksi",
          class: "bg-slate-100 text-slate-600 border border-slate-200",
        };
      }

      if (!props.pengaturan?.latitude_sekolah) {
        return {
          text: "Koordinat sekolah belum diatur",
          class: "bg-orange-100 text-orange-700 border border-orange-200",
        };
      }

      const distance = calculateDistance(
        userLocation.value.latitude,
        userLocation.value.longitude,
        props.pengaturan.latitude_sekolah,
        props.pengaturan.longitude_sekolah
      );

      if (distance <= (props.pengaturan.radius_absensi || 100)) {
        return {
          text: `Dalam radius absensi (${Math.round(distance)}m)`,
          class: "bg-green-100 text-green-700 border border-green-200",
        };
      } else {
        return {
          text: `Di luar radius absensi (${Math.round(distance)}m)`,
          class: "bg-red-100 text-red-700 border border-red-200",
        };
      }
    });

    // Prediksi status berdasarkan waktu
    const predictedStatus = computed(() => {
      const now = new Date();
      const currentTimeStr =
        now.getHours().toString().padStart(2, "0") +
        ":" +
        now.getMinutes().toString().padStart(2, "0");

      const jamNormal =
        formatTime(props.pengaturan?.jam_masuk_normal) || "08:00";
      const jamTelat = formatTime(props.pengaturan?.jam_masuk_telat) || "08:30";

      if (currentTimeStr <= jamNormal) {
        return {
          text: "Masuk Normal",
          class: "bg-green-100 text-green-700 border border-green-200",
        };
      } else if (currentTimeStr <= jamTelat) {
        return {
          text: "Masuk (Mendekati Telat)",
          class: "bg-yellow-100 text-yellow-700 border border-yellow-200",
        };
      } else {
        return {
          text: "Telat",
          class: "bg-red-100 text-red-700 border border-red-200",
        };
      }
    });

    const getCurrentLocation = () => {
      if (!navigator.geolocation) {
        alert("Geolokasi tidak didukung oleh browser ini.");
        return;
      }

      gettingLocation.value = true;

      navigator.geolocation.getCurrentPosition(
        (position) => {
          userLocation.value = {
            latitude: position.coords.latitude,
            longitude: position.coords.longitude,
          };
          gettingLocation.value = false;
        },
        (error) => {
          gettingLocation.value = false;
          alert("Gagal mendapatkan lokasi: " + error.message);
        },
        {
          enableHighAccuracy: true,
          timeout: 15000,
          maximumAge: 30000,
        }
      );
    };

    const submitPresensi = (type) => {
      if (!userLocation.value.latitude) {
        alert("Silakan ambil lokasi terlebih dahulu");
        return;
      }

      if (type === "masuk") {
        formMasuk.latitude = userLocation.value.latitude;
        formMasuk.longitude = userLocation.value.longitude;
        formMasuk.post("/presensi");
      } else {
        formPulang.latitude = userLocation.value.latitude;
        formPulang.longitude = userLocation.value.longitude;
        formPulang.post("/presensi");
      }
    };

    const calculateDistance = (lat1, lon1, lat2, lon2) => {
      const R = 6371000; // Earth radius in meters
      const dLat = ((lat2 - lat1) * Math.PI) / 180;
      const dLon = ((lon2 - lon1) * Math.PI) / 180;
      const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos((lat1 * Math.PI) / 180) *
          Math.cos((lat2 * Math.PI) / 180) *
          Math.sin(dLon / 2) *
          Math.sin(dLon / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c;
    };

    const updateCurrentTime = () => {
      const now = new Date();
      currentTime.value = now.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        timeZone: "Asia/Jakarta",
      });
    };

    const showLocationModal = (presensi) => {
      selectedPresensi.value = presensi;
      showLocationInfo.value = true;
    };

    const formatDateCorrect = (dateString) => {
      if (!dateString) return "";
      const dateParts = dateString.split("-");
      const year = parseInt(dateParts[0]);
      const month = parseInt(dateParts[1]) - 1;
      const day = parseInt(dateParts[2]);
      const date = new Date(year, month, day);
      return date.toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
        timeZone: "Asia/Jakarta",
      });
    };

    const formatTime = (time) => {
      if (!time) return "";
      return time.length > 5 ? time.substring(0, 5) : time;
    };

    const formatStatus = (status) => {
      const statusMap = {
        masuk: "Masuk",
        telat: "Telat",
        alpha: "Alpha",
        izin: "Izin",
      };
      return statusMap[status] || status;
    };

    const getStatusClass = (status) => {
      const classMap = {
        masuk: "bg-green-100 text-green-700 border border-green-200",
        telat: "bg-yellow-100 text-yellow-700 border border-yellow-200",
        alpha: "bg-red-100 text-red-700 border border-red-200",
        izin: "bg-blue-100 text-blue-700 border border-blue-200",
      };
      return (
        classMap[status] ||
        "bg-slate-100 text-slate-600 border border-slate-200"
      );
    };

    let timeInterval;
    onMounted(() => {
      updateCurrentTime();
      timeInterval = setInterval(updateCurrentTime, 1000);

      if (!props.isAdmin) {
        getCurrentLocation();
      }
    });

    onUnmounted(() => {
      if (timeInterval) {
        clearInterval(timeInterval);
      }
    });

    return {
      formMasuk,
      formPulang,
      userLocation,
      gettingLocation,
      locationStatus,
      predictedStatus,
      showLocationInfo,
      selectedPresensi,
      currentTime,
      getCurrentLocation,
      submitPresensi,
      showLocationModal,
      formatDateCorrect,
      formatTime,
      formatStatus,
      getStatusClass,
    };
  },
};
</script>
