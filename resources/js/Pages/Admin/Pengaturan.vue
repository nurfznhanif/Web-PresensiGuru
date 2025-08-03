<template>
  <AppLayout>
    <div class="py-8 px-4 sm:px-6 lg:px-8">
      <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
          <h1
            class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-2"
          >
            Pengaturan Sistem
          </h1>
          <p class="text-slate-600">
            Konfigurasi jam kerja dan lokasi absensi untuk sistem presensi
          </p>
        </div>

        <form @submit.prevent="submitForm">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Working Hours Settings -->
            <div
              class="bg-white/80 backdrop-blur-lg shadow-xl rounded-3xl p-8 border border-white/20"
            >
              <div class="flex items-center mb-6">
                <div
                  class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mr-4"
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
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-800">
                  Pengaturan Jam Kerja
                </h2>
              </div>

              <div class="space-y-6">
                <!-- Jam Masuk Normal -->
                <div>
                  <label
                    class="block text-sm font-semibold text-slate-700 mb-2"
                  >
                    <svg
                      class="w-4 h-4 inline mr-2 text-green-500"
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
                    Jam Masuk Normal
                  </label>
                  <input
                    v-model="form.jam_masuk_normal"
                    type="time"
                    required
                    class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    :class="{
                      'border-red-400 ring-red-200': errors.jam_masuk_normal,
                    }"
                  />
                  <div
                    v-if="errors.jam_masuk_normal"
                    class="text-red-500 text-sm mt-1 flex items-center"
                  >
                    <svg
                      class="w-4 h-4 mr-1"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                    {{ errors.jam_masuk_normal }}
                  </div>
                </div>

                <!-- Batas Waktu Telat -->
                <div>
                  <label
                    class="block text-sm font-semibold text-slate-700 mb-2"
                  >
                    <svg
                      class="w-4 h-4 inline mr-2 text-yellow-500"
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
                    Batas Waktu Telat
                  </label>
                  <input
                    v-model="form.jam_masuk_telat"
                    type="time"
                    required
                    class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    :class="{
                      'border-red-400 ring-red-200': errors.jam_masuk_telat,
                    }"
                  />
                  <div
                    v-if="errors.jam_masuk_telat"
                    class="text-red-500 text-sm mt-1 flex items-center"
                  >
                    <svg
                      class="w-4 h-4 mr-1"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                    {{ errors.jam_masuk_telat }}
                  </div>
                </div>

                <!-- Jam Pulang Normal -->
                <div>
                  <label
                    class="block text-sm font-semibold text-slate-700 mb-2"
                  >
                    <svg
                      class="w-4 h-4 inline mr-2 text-blue-500"
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
                    Jam Pulang Normal
                  </label>
                  <input
                    v-model="form.jam_pulang_normal"
                    type="time"
                    required
                    class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    :class="{
                      'border-red-400 ring-red-200': errors.jam_pulang_normal,
                    }"
                  />
                  <div
                    v-if="errors.jam_pulang_normal"
                    class="text-red-500 text-sm mt-1 flex items-center"
                  >
                    <svg
                      class="w-4 h-4 mr-1"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                    {{ errors.jam_pulang_normal }}
                  </div>
                </div>
              </div>

              <!-- Time Preview -->
              <div
                class="mt-6 p-4 bg-gradient-to-br from-slate-50 to-gray-50 rounded-2xl border border-slate-200"
              >
                <h3 class="font-semibold text-slate-700 mb-3 flex items-center">
                  <svg
                    class="w-4 h-4 mr-2 text-slate-600"
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
                  Pratinjau Jadwal
                </h3>
                <div class="grid grid-cols-3 gap-3 text-center">
                  <div class="p-2 bg-white rounded-lg border border-green-200">
                    <p class="text-xs text-green-600 font-medium">
                      Masuk Normal
                    </p>
                    <p class="text-sm font-bold text-slate-800">
                      {{ form.jam_masuk_normal || "08:00" }}
                    </p>
                  </div>
                  <div class="p-2 bg-white rounded-lg border border-yellow-200">
                    <p class="text-xs text-yellow-600 font-medium">
                      Batas Telat
                    </p>
                    <p class="text-sm font-bold text-slate-800">
                      {{ form.jam_masuk_telat || "08:30" }}
                    </p>
                  </div>
                  <div class="p-2 bg-white rounded-lg border border-blue-200">
                    <p class="text-xs text-blue-600 font-medium">Jam Pulang</p>
                    <p class="text-sm font-bold text-slate-800">
                      {{ form.jam_pulang_normal || "16:00" }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Location Settings -->
            <div
              class="bg-white/80 backdrop-blur-lg shadow-xl rounded-3xl p-8 border border-white/20"
            >
              <div class="flex items-center mb-6">
                <div
                  class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-500 rounded-xl flex items-center justify-center mr-4"
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
                <h2 class="text-xl font-bold text-slate-800">
                  Pengaturan Lokasi Absensi
                </h2>
              </div>

              <div class="space-y-6">
                <!-- Nama Lokasi -->
                <div>
                  <label
                    class="block text-sm font-semibold text-slate-700 mb-2"
                  >
                    <svg
                      class="w-4 h-4 inline mr-2 text-blue-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                      />
                    </svg>
                    Nama Lokasi
                  </label>
                  <input
                    v-model="form.nama_lokasi"
                    type="text"
                    required
                    class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    :class="{
                      'border-red-400 ring-red-200': errors.nama_lokasi,
                    }"
                    placeholder="Contoh: SD 003 YKWI Pekanbaru"
                  />
                  <div
                    v-if="errors.nama_lokasi"
                    class="text-red-500 text-sm mt-1 flex items-center"
                  >
                    <svg
                      class="w-4 h-4 mr-1"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                    {{ errors.nama_lokasi }}
                  </div>
                </div>

                <!-- Alamat Lokasi -->
                <div>
                  <label
                    class="block text-sm font-semibold text-slate-700 mb-2"
                  >
                    <svg
                      class="w-4 h-4 inline mr-2 text-blue-500"
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
                    Alamat Lokasi
                  </label>
                  <textarea
                    v-model="form.alamat_lokasi"
                    rows="3"
                    class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 resize-none"
                    :class="{
                      'border-red-400 ring-red-200': errors.alamat_lokasi,
                    }"
                    placeholder="Masukkan alamat lengkap lokasi sekolah"
                  ></textarea>
                  <div
                    v-if="errors.alamat_lokasi"
                    class="text-red-500 text-sm mt-1 flex items-center"
                  >
                    <svg
                      class="w-4 h-4 mr-1"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                    {{ errors.alamat_lokasi }}
                  </div>
                </div>

                <!-- Koordinat Lokasi -->
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label
                      class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                      <svg
                        class="w-4 h-4 inline mr-2 text-red-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                        />
                      </svg>
                      Latitude
                    </label>
                    <input
                      v-model="form.latitude_sekolah"
                      type="number"
                      step="any"
                      required
                      class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                      :class="{
                        'border-red-400 ring-red-200': errors.latitude_sekolah,
                      }"
                      placeholder="0.533333"
                    />
                    <div
                      v-if="errors.latitude_sekolah"
                      class="text-red-500 text-sm mt-1 flex items-center"
                    >
                      <svg
                        class="w-4 h-4 mr-1"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                      </svg>
                      {{ errors.latitude_sekolah }}
                    </div>
                  </div>

                  <div>
                    <label
                      class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                      <svg
                        class="w-4 h-4 inline mr-2 text-blue-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"
                        />
                      </svg>
                      Longitude
                    </label>
                    <input
                      v-model="form.longitude_sekolah"
                      type="number"
                      step="any"
                      required
                      class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                      :class="{
                        'border-red-400 ring-red-200': errors.longitude_sekolah,
                      }"
                      placeholder="101.433333"
                    />
                    <div
                      v-if="errors.longitude_sekolah"
                      class="text-red-500 text-sm mt-1 flex items-center"
                    >
                      <svg
                        class="w-4 h-4 mr-1"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                      </svg>
                      {{ errors.longitude_sekolah }}
                    </div>
                  </div>
                </div>

                <!-- Radius Absensi -->
                <div>
                  <label
                    class="block text-sm font-semibold text-slate-700 mb-2"
                  >
                    <svg
                      class="w-4 h-4 inline mr-2 text-purple-500"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"
                      />
                    </svg>
                    Radius Absensi (meter)
                  </label>
                  <input
                    v-model="form.radius_absensi"
                    type="number"
                    min="10"
                    max="1000"
                    required
                    class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    :class="{
                      'border-red-400 ring-red-200': errors.radius_absensi,
                    }"
                    placeholder="100"
                  />
                  <div
                    v-if="errors.radius_absensi"
                    class="text-red-500 text-sm mt-1 flex items-center"
                  >
                    <svg
                      class="w-4 h-4 mr-1"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                    {{ errors.radius_absensi }}
                  </div>
                  <p class="text-sm text-slate-500 mt-2 flex items-center">
                    <svg
                      class="w-4 h-4 mr-1"
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
                    Jarak maksimal dari lokasi sekolah untuk bisa melakukan
                    absensi
                  </p>
                </div>

                <!-- Get Current Location Button -->
                <div>
                  <button
                    type="button"
                    @click="getCurrentLocation"
                    :disabled="gettingLocation"
                    class="w-full bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:transform-none flex items-center justify-center"
                  >
                    <svg
                      class="w-5 h-5 mr-2"
                      :class="{ 'animate-spin': gettingLocation }"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        v-if="!gettingLocation"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                      />
                      <circle
                        v-else
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                      ></circle>
                    </svg>
                    {{
                      gettingLocation
                        ? "Mengambil Lokasi..."
                        : "Ambil Lokasi Saat Ini"
                    }}
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Location Preview -->
          <div
            class="bg-white/80 backdrop-blur-lg shadow-xl rounded-3xl p-8 border border-white/20 mb-8"
          >
            <div class="flex items-center mb-6">
              <div
                class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mr-4"
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
                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"
                  />
                </svg>
              </div>
              <h2 class="text-xl font-bold text-slate-800">Preview Lokasi</h2>
            </div>

            <div v-if="hasLocationData" class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                  <div
                    class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-200"
                  >
                    <span class="text-sm font-medium text-slate-700"
                      >Nama Lokasi:</span
                    >
                    <span class="text-sm font-bold text-slate-900">{{
                      form.nama_lokasi || "Belum diisi"
                    }}</span>
                  </div>
                  <div
                    class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200"
                  >
                    <span class="text-sm font-medium text-slate-700"
                      >Latitude:</span
                    >
                    <span class="text-sm font-bold text-slate-900">{{
                      form.latitude_sekolah || "0.000000"
                    }}</span>
                  </div>
                  <div
                    class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl border border-purple-200"
                  >
                    <span class="text-sm font-medium text-slate-700"
                      >Longitude:</span
                    >
                    <span class="text-sm font-bold text-slate-900">{{
                      form.longitude_sekolah || "0.000000"
                    }}</span>
                  </div>
                </div>
                <div class="space-y-3">
                  <div
                    class="p-4 bg-gradient-to-r from-orange-50 to-yellow-50 rounded-xl border border-orange-200"
                  >
                    <span class="text-sm font-medium text-slate-700 block mb-1"
                      >Alamat:</span
                    >
                    <span class="text-sm text-slate-900">{{
                      form.alamat_lokasi || "Belum diisi"
                    }}</span>
                  </div>
                  <div
                    class="flex items-center justify-between p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl border border-pink-200"
                  >
                    <span class="text-sm font-medium text-slate-700"
                      >Radius Absensi:</span
                    >
                    <span class="text-sm font-bold text-slate-900"
                      >{{ form.radius_absensi || "100" }} meter</span
                    >
                  </div>
                </div>
              </div>
            </div>

            <div
              v-else
              class="bg-gradient-to-br from-slate-100 to-gray-100 rounded-2xl p-8 text-center border-2 border-dashed border-slate-300"
            >
              <div
                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <svg
                  class="w-8 h-8 text-white"
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
              <h3 class="text-lg font-semibold text-slate-600 mb-2">
                Belum Ada Data Lokasi
              </h3>
              <p class="text-slate-500">
                Silakan isi koordinat lokasi untuk melihat preview
              </p>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="text-center">
            <button
              type="submit"
              :disabled="isSubmitting"
              class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:transform-none shadow-lg"
            >
              <svg
                v-if="isSubmitting"
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              <svg
                v-else
                class="w-5 h-5 mr-3"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"
                />
              </svg>
              {{
                isSubmitting ? "Menyimpan Pengaturan..." : "Simpan Pengaturan"
              }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, reactive, onMounted, computed } from "vue";
import axios from "axios";

export default {
  components: {
    AppLayout,
  },
  setup() {
    // Reactive data
    const isSubmitting = ref(false);
    const gettingLocation = ref(false);
    const errors = ref({});

    // Form data
    const form = reactive({
      jam_masuk_normal: "",
      jam_masuk_telat: "",
      jam_pulang_normal: "",
      nama_lokasi: "",
      alamat_lokasi: "",
      latitude_sekolah: "",
      longitude_sekolah: "",
      radius_absensi: "",
    });

    // Computed properties
    const hasLocationData = computed(() => {
      return (
        form.nama_lokasi ||
        form.latitude_sekolah ||
        form.longitude_sekolah ||
        form.alamat_lokasi
      );
    });

    // Methods
    const fetchSettings = async () => {
      try {
        const response = await axios.get("/api/settings");
        const settings = response.data.data;

        // Map settings to form
        if (settings) {
          Object.keys(form).forEach((key) => {
            if (settings[key] !== undefined) {
              form[key] = settings[key];
            }
          });
        }
      } catch (error) {
        console.error("Error fetching settings:", error);
      }
    };

    const getCurrentLocation = () => {
      if (!navigator.geolocation) {
        alert("Geolocation tidak didukung oleh browser ini.");
        return;
      }

      gettingLocation.value = true;

      navigator.geolocation.getCurrentPosition(
        (position) => {
          form.latitude_sekolah = position.coords.latitude.toFixed(6);
          form.longitude_sekolah = position.coords.longitude.toFixed(6);
          gettingLocation.value = false;

          // Optional: Get address from coordinates using reverse geocoding
          getAddressFromCoordinates(
            position.coords.latitude,
            position.coords.longitude
          );
        },
        (error) => {
          gettingLocation.value = false;
          let errorMessage = "Gagal mendapatkan lokasi.";

          switch (error.code) {
            case error.PERMISSION_DENIED:
              errorMessage =
                "Akses lokasi ditolak. Silakan izinkan akses lokasi di browser.";
              break;
            case error.POSITION_UNAVAILABLE:
              errorMessage = "Informasi lokasi tidak tersedia.";
              break;
            case error.TIMEOUT:
              errorMessage = "Timeout dalam mendapatkan lokasi.";
              break;
          }

          alert(errorMessage);
        },
        {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 0,
        }
      );
    };

    const getAddressFromCoordinates = async (lat, lng) => {
      try {
        // Using a free geocoding service (you might want to use Google Maps API or similar)
        const response = await fetch(
          `https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lng}&key=YOUR_API_KEY`
        );

        if (response.ok) {
          const data = await response.json();
          if (data.results && data.results.length > 0) {
            form.alamat_lokasi = data.results[0].formatted;
          }
        }
      } catch (error) {
        console.log("Could not get address from coordinates:", error);
        // This is optional, so we don't show an error to the user
      }
    };

    const validateForm = () => {
      errors.value = {};
      let isValid = true;

      // Validate working hours
      if (!form.jam_masuk_normal) {
        errors.value.jam_masuk_normal = "Jam masuk normal harus diisi";
        isValid = false;
      }

      if (!form.jam_masuk_telat) {
        errors.value.jam_masuk_telat = "Batas waktu telat harus diisi";
        isValid = false;
      }

      if (!form.jam_pulang_normal) {
        errors.value.jam_pulang_normal = "Jam pulang normal harus diisi";
        isValid = false;
      }

      // Validate time logic
      if (form.jam_masuk_normal && form.jam_masuk_telat) {
        if (form.jam_masuk_normal >= form.jam_masuk_telat) {
          errors.value.jam_masuk_telat =
            "Batas waktu telat harus lebih besar dari jam masuk normal";
          isValid = false;
        }
      }

      if (form.jam_masuk_normal && form.jam_pulang_normal) {
        if (form.jam_masuk_normal >= form.jam_pulang_normal) {
          errors.value.jam_pulang_normal =
            "Jam pulang harus lebih besar dari jam masuk";
          isValid = false;
        }
      }

      // Validate location
      if (!form.nama_lokasi) {
        errors.value.nama_lokasi = "Nama lokasi harus diisi";
        isValid = false;
      }

      if (!form.latitude_sekolah) {
        errors.value.latitude_sekolah = "Latitude harus diisi";
        isValid = false;
      }

      if (!form.longitude_sekolah) {
        errors.value.longitude_sekolah = "Longitude harus diisi";
        isValid = false;
      }

      if (!form.radius_absensi) {
        errors.value.radius_absensi = "Radius absensi harus diisi";
        isValid = false;
      } else if (form.radius_absensi < 10 || form.radius_absensi > 1000) {
        errors.value.radius_absensi =
          "Radius absensi harus antara 10-1000 meter";
        isValid = false;
      }

      return isValid;
    };

    const submitForm = async () => {
      if (!validateForm()) {
        return;
      }

      isSubmitting.value = true;

      try {
        const response = await axios.post("/api/settings", form);

        // Show success message
        alert("Pengaturan berhasil disimpan!");

        // Optionally redirect or update UI
        console.log("Settings saved successfully:", response.data);
      } catch (error) {
        if (error.response && error.response.status === 422) {
          errors.value = error.response.data.errors || {};
        } else {
          alert(
            "Terjadi kesalahan saat menyimpan pengaturan. Silakan coba lagi."
          );
          console.error("Error saving settings:", error);
        }
      } finally {
        isSubmitting.value = false;
      }
    };

    const resetForm = () => {
      Object.keys(form).forEach((key) => {
        form[key] = "";
      });
      errors.value = {};
    };

    // Lifecycle
    onMounted(() => {
      fetchSettings();
    });

    return {
      // Data
      isSubmitting,
      gettingLocation,
      errors,
      form,

      // Computed
      hasLocationData,

      // Methods
      getCurrentLocation,
      submitForm,
      resetForm,
    };
  },
};
</script>
