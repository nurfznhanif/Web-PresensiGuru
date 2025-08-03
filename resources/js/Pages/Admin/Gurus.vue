<template>
  <AppLayout>
    <div class="py-8 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div
          class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8"
        >
          <div>
            <h1
              class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-2"
            >
              Data Guru
            </h1>
            <p class="text-slate-600">
              Kelola data guru dan pantau status presensi mereka
            </p>
          </div>
          <button
            @click="openAddForm"
            class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg"
          >
            <svg
              class="w-5 h-5 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
              />
            </svg>
            Tambah Guru
          </button>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div
            class="bg-white/80 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-lg"
          >
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center"
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
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                  />
                </svg>
              </div>
              <div class="ml-4">
                <div class="text-2xl font-bold text-slate-800">
                  {{ gurus.length }}
                </div>
                <div class="text-sm text-slate-600">Total Guru</div>
              </div>
            </div>
          </div>

          <div
            class="bg-white/80 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-lg"
          >
            <div class="flex items-center">
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
              <div class="ml-4">
                <div class="text-2xl font-bold text-slate-800">{{ hadir }}</div>
                <div class="text-sm text-slate-600">Hadir Hari Ini</div>
              </div>
            </div>
          </div>

          <div
            class="bg-white/80 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-lg"
          >
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center"
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
              <div class="ml-4">
                <div class="text-2xl font-bold text-slate-800">{{ telat }}</div>
                <div class="text-sm text-slate-600">Telat Hari Ini</div>
              </div>
            </div>
          </div>

          <div
            class="bg-white/80 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-lg"
          >
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center"
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
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </div>
              <div class="ml-4">
                <div class="text-2xl font-bold text-slate-800">{{ alpha }}</div>
                <div class="text-sm text-slate-600">Alpha Hari Ini</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Content -->
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
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                />
              </svg>
              Daftar Guru
            </h2>
          </div>

          <!-- Teachers Table -->
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
              <thead class="bg-gradient-to-r from-slate-50 to-gray-50">
                <tr>
                  <th
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Guru
                  </th>
                  <th
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Kontak
                  </th>
                  <th
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Status Hari Ini
                  </th>
                  <th
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Jam Masuk
                  </th>
                  <th
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Jam Pulang
                  </th>
                  <th
                    class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider"
                  >
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-slate-100">
                <tr
                  v-for="guru in gurus"
                  :key="guru.id"
                  class="hover:bg-slate-50 transition-colors duration-200"
                >
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div
                        class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-lg mr-4"
                      >
                        {{ guru.name.charAt(0).toUpperCase() }}
                      </div>
                      <div>
                        <div class="text-sm font-semibold text-slate-900">
                          {{ guru.name }}
                        </div>
                        <div class="text-xs text-slate-500">
                          NIP: {{ guru.nip }}
                        </div>
                        <div class="text-xs text-slate-400">
                          Bergabung {{ formatDate(guru.created_at) }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center text-sm text-slate-600">
                      <svg
                        class="w-4 h-4 mr-2 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                        />
                      </svg>
                      {{ guru.email }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      v-if="guru.presensi_hari_ini"
                      :class="
                        getStatusClass(guru.presensi_hari_ini.status_masuk)
                      "
                      class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
                    >
                      <div class="w-2 h-2 rounded-full bg-current mr-2"></div>
                      {{ formatStatus(guru.presensi_hari_ini.status_masuk) }}
                    </span>
                    <span
                      v-else
                      class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600"
                    >
                      <div class="w-2 h-2 rounded-full bg-current mr-2"></div>
                      Belum Presensi
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div
                      v-if="guru.presensi_hari_ini?.jam_masuk"
                      class="flex items-center text-sm text-slate-900"
                    >
                      <svg
                        class="w-4 h-4 mr-2 text-green-500"
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
                      {{ guru.presensi_hari_ini.jam_masuk }}
                    </div>
                    <span v-else class="text-slate-400">-</span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div
                      v-if="guru.presensi_hari_ini?.jam_pulang"
                      class="flex items-center text-sm text-slate-900"
                    >
                      <svg
                        class="w-4 h-4 mr-2 text-blue-500"
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
                      {{ guru.presensi_hari_ini.jam_pulang }}
                    </div>
                    <span v-else class="text-slate-400">-</span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex space-x-2">
                      <button
                        @click="openEditForm(guru)"
                        class="inline-flex items-center px-3 py-1 bg-amber-100 hover:bg-amber-200 text-amber-700 text-xs font-medium rounded-lg transition-all duration-200 transform hover:scale-105"
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
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                          />
                        </svg>
                        Edit
                      </button>
                      <button
                        @click="openDeleteConfirm(guru)"
                        class="inline-flex items-center px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition-all duration-200 transform hover:scale-105"
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
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                          />
                        </svg>
                        Hapus
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- No Data State -->
          <div v-if="gurus.length === 0" class="text-center py-12">
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
                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-600 mb-2">
              Belum Ada Data Guru
            </h3>
            <p class="text-slate-500 mb-4">
              Tambahkan guru pertama untuk memulai
            </p>
            <button
              @click="openAddForm"
              class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300"
            >
              <svg
                class="w-4 h-4 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                />
              </svg>
              Tambah Guru
            </button>
          </div>
        </div>

        <!-- Form Modal -->
        <div
          v-if="showForm"
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
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                  {{ editMode ? "Edit Guru" : "Tambah Guru Baru" }}
                </h3>
                <button
                  @click="closeForm"
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

              <form @submit.prevent="submitForm" class="space-y-4">
                <!-- Name Field -->
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
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                      />
                    </svg>
                    Nama Lengkap
                  </label>
                  <input
                    v-model="form.name"
                    type="text"
                    required
                    class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    :class="{ 'border-red-400 ring-red-200': formErrors.name }"
                    placeholder="Masukkan nama lengkap"
                  />
                  <div
                    v-if="formErrors.name"
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
                    {{ formErrors.name[0] }}
                  </div>
                </div>

                <!-- Email Field -->
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
                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                      />
                    </svg>
                    Email
                  </label>
                  <input
                    v-model="form.email"
                    type="email"
                    required
                    class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    :class="{ 'border-red-400 ring-red-200': formErrors.email }"
                    placeholder="Masukkan email"
                  />
                  <div
                    v-if="formErrors.email"
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
                    {{ formErrors.email[0] }}
                  </div>
                </div>

                <!-- NIP Field -->
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
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                      />
                    </svg>
                    NIP
                  </label>
                  <input
                    v-model="form.nip"
                    type="text"
                    required
                    class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    :class="{ 'border-red-400 ring-red-200': formErrors.nip }"
                    placeholder="Masukkan NIP"
                  />
                  <div
                    v-if="formErrors.nip"
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
                    {{ formErrors.nip[0] }}
                  </div>
                </div>

                <!-- Password Field -->
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
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                      />
                    </svg>
                    Password
                    {{
                      editMode ? "(Kosongkan jika tidak ingin mengubah)" : ""
                    }}
                  </label>
                  <div class="relative">
                    <input
                      v-model="form.password"
                      :type="showPassword ? 'text' : 'password'"
                      :required="!editMode"
                      class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 pr-12"
                      :class="{
                        'border-red-400 ring-red-200': formErrors.password,
                      }"
                      placeholder="Masukkan password"
                    />
                    <button
                      type="button"
                      @click="showPassword = !showPassword"
                      class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600"
                    >
                      <svg
                        v-if="showPassword"
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"
                        />
                      </svg>
                      <svg
                        v-else
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        />
                      </svg>
                    </button>
                  </div>
                  <div
                    v-if="formErrors.password"
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
                    {{ formErrors.password[0] }}
                  </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-4">
                  <button
                    type="button"
                    @click="closeForm"
                    class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-all duration-300"
                  >
                    Batal
                  </button>
                  <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:transform-none flex items-center"
                  >
                    <svg
                      v-if="isSubmitting"
                      class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
                    {{ isSubmitting ? "Menyimpan..." : "Simpan" }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div
          v-if="showDeleteConfirm"
          class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4"
        >
          <div
            class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full mx-auto transform transition-all duration-300 scale-100"
          >
            <div class="p-6 text-center">
              <div
                class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <svg
                  class="w-8 h-8 text-red-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                  />
                </svg>
              </div>
              <h3 class="text-xl font-bold text-slate-800 mb-2">
                Konfirmasi Penghapusan
              </h3>
              <p class="text-slate-600 mb-2">
                Apakah Anda yakin ingin menghapus guru
                <span class="font-semibold text-slate-800">{{
                  deleteTarget?.name
                }}</span
                >?
              </p>
              <p class="text-sm text-red-600 mb-6">
                Data presensi guru ini juga akan ikut terhapus dan tidak dapat
                dikembalikan!
              </p>

              <div class="flex justify-center space-x-3">
                <button
                  @click="showDeleteConfirm = false"
                  class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-all duration-300"
                >
                  Batal
                </button>
                <button
                  @click="confirmDelete"
                  :disabled="isDeleting"
                  class="px-6 py-3 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:transform-none flex items-center"
                >
                  <svg
                    v-if="isDeleting"
                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
                  {{ isDeleting ? "Menghapus..." : "Hapus" }}
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
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, reactive, onMounted, computed } from "vue";
import axios from "axios";

export default {
  components: {
    AppLayout,
  },
  setup() {
    // Reactive data
    const gurus = ref([]);
    const showForm = ref(false);
    const showDeleteConfirm = ref(false);
    const editMode = ref(false);
    const isSubmitting = ref(false);
    const isDeleting = ref(false);
    const formErrors = ref({});
    const deleteTarget = ref(null);
    const showPassword = ref(false);

    // Form data
    const form = reactive({
      id: null,
      name: "",
      email: "",
      nip: "",
      password: "",
    });

    // Computed properties for stats
    const hadir = computed(() => {
      return gurus.value.filter(
        (guru) =>
          guru.presensi_hari_ini &&
          guru.presensi_hari_ini.status_masuk === "masuk"
      ).length;
    });

    const telat = computed(() => {
      return gurus.value.filter(
        (guru) =>
          guru.presensi_hari_ini &&
          guru.presensi_hari_ini.status_masuk === "telat"
      ).length;
    });

    const alpha = computed(() => {
      return gurus.value.filter(
        (guru) =>
          !guru.presensi_hari_ini ||
          guru.presensi_hari_ini.status_masuk === "alpha"
      ).length;
    });

    // Methods
    const fetchGurus = async () => {
      try {
        const response = await axios.get("/api/gurus");
        gurus.value = response.data.data;
      } catch (error) {
        console.error("Error fetching gurus:", error);
      }
    };

    const openAddForm = () => {
      editMode.value = false;
      resetForm();
      showForm.value = true;
    };

    const openEditForm = (guru) => {
      editMode.value = true;
      form.id = guru.id;
      form.name = guru.name;
      form.email = guru.email;
      form.nip = guru.nip;
      form.password = "";
      showForm.value = true;
    };

    const submitForm = async () => {
      isSubmitting.value = true;
      formErrors.value = {};

      try {
        let response;

        if (editMode.value) {
          response = await axios.put(`/api/gurus/${form.id}`, form);
          const index = gurus.value.findIndex((g) => g.id === form.id);
          if (index !== -1) {
            gurus.value[index] = {
              ...gurus.value[index],
              ...response.data.data,
            };
          }
        } else {
          response = await axios.post("/api/gurus", form);
          gurus.value.push(response.data.data);
        }

        closeForm();
        console.log(
          editMode.value
            ? "Data guru berhasil diperbarui!"
            : "Guru berhasil ditambahkan!"
        );
      } catch (error) {
        if (error.response && error.response.status === 422) {
          formErrors.value = error.response.data.errors;
        } else {
          console.error("Terjadi kesalahan saat menyimpan data");
        }
      } finally {
        isSubmitting.value = false;
      }
    };

    const openDeleteConfirm = (guru) => {
      deleteTarget.value = guru;
      showDeleteConfirm.value = true;
    };

    const confirmDelete = async () => {
      isDeleting.value = true;

      try {
        await axios.delete(`/api/gurus/${deleteTarget.value.id}`);
        gurus.value = gurus.value.filter((g) => g.id !== deleteTarget.value.id);
        showDeleteConfirm.value = false;
        deleteTarget.value = null;
        console.log("Data guru berhasil dihapus!");
      } catch (error) {
        console.error("Terjadi kesalahan saat menghapus data");
      } finally {
        isDeleting.value = false;
      }
    };

    const closeForm = () => {
      showForm.value = false;
      formErrors.value = {};
      resetForm();
    };

    const resetForm = () => {
      form.id = null;
      form.name = "";
      form.email = "";
      form.nip = "";
      form.password = "";
    };

    const formatDate = (dateString) => {
      return new Date(dateString).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
      });
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

    // Lifecycle
    onMounted(() => {
      fetchGurus();
      // Auto-refresh every 30 seconds
      setInterval(fetchGurus, 30000);
    });

    return {
      // Data
      gurus,
      showForm,
      showDeleteConfirm,
      editMode,
      isSubmitting,
      isDeleting,
      formErrors,
      deleteTarget,
      showPassword,
      form,

      // Computed
      hadir,
      telat,
      alpha,

      // Methods
      openAddForm,
      openEditForm,
      submitForm,
      openDeleteConfirm,
      confirmDelete,
      closeForm,
      formatDate,
      formatStatus,
      getStatusClass,
    };
  },
};
</script>
