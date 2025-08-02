<template>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">
              {{ isAdmin ? "Data Presensi Guru" : "Presensi Saya" }}
            </h1>

            <!-- Form Presensi untuk Guru -->
            <div v-if="!isAdmin" class="mb-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Presensi Hari Ini</h2>

                <!-- Info Lokasi -->
                <div class="mb-4 p-4 bg-yellow-100 rounded-lg">
                  <h3 class="font-semibold text-yellow-800 mb-2">
                    Informasi Lokasi Absensi
                  </h3>
                  <p class="text-sm text-yellow-700">
                    <strong>{{
                      pengaturan?.nama_lokasi || "Lokasi Belum Diatur"
                    }}</strong
                    ><br />
                    {{ pengaturan?.alamat_lokasi || "Alamat belum diatur"
                    }}<br />
                    Radius absensi:
                    {{ pengaturan?.radius_absensi || 100 }} meter
                  </p>

                  <!-- Debug Info Lokasi -->
                  <div
                    v-if="userLocation.latitude"
                    class="mt-2 p-2 bg-blue-100 rounded text-xs"
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

                  <div class="mt-2">
                    <span
                      :class="locationStatus.class"
                      class="px-2 py-1 text-xs font-semibold rounded-full"
                    >
                      {{ locationStatus.text }}
                    </span>
                  </div>

                  <button
                    @click="getCurrentLocation"
                    :disabled="gettingLocation"
                    class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm disabled:opacity-50"
                  >
                    {{
                      gettingLocation ? "Mengambil Lokasi..." : "Refresh Lokasi"
                    }}
                  </button>
                </div>

                <!-- Status Presensi Hari Ini -->
                <div
                  v-if="presensiHariIni"
                  class="mb-4 p-4 bg-green-100 rounded"
                >
                  <p>
                    <strong>Status Masuk:</strong>
                    {{ formatStatus(presensiHariIni.status_masuk) }}
                  </p>
                  <p v-if="presensiHariIni.jam_masuk">
                    <strong>Jam Masuk:</strong> {{ presensiHariIni.jam_masuk }}
                  </p>
                  <p v-if="presensiHariIni.jam_pulang">
                    <strong>Jam Pulang:</strong>
                    {{ presensiHariIni.jam_pulang }}
                  </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <!-- Form Presensi Masuk -->
                  <div class="border p-4 rounded">
                    <h3 class="font-semibold mb-3">Presensi Masuk</h3>

                    <!-- Prediksi Status -->
                    <div class="mb-3 p-3 bg-gray-100 rounded">
                      <p class="text-sm font-medium">Status Otomatis:</p>
                      <span
                        :class="predictedStatus.class"
                        class="px-2 py-1 text-xs font-semibold rounded-full"
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
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 disabled:opacity-50"
                      >
                        {{
                          presensiHariIni && presensiHariIni.jam_masuk
                            ? "Sudah Presensi Masuk"
                            : !userLocation.latitude
                            ? "Ambil Lokasi Dulu"
                            : gettingLocation
                            ? "Mengambil Lokasi..."
                            : "Presensi Masuk"
                        }}
                      </button>
                    </form>
                  </div>

                  <!-- Form Presensi Pulang -->
                  <div class="border p-4 rounded">
                    <h3 class="font-semibold mb-3">Presensi Pulang</h3>
                    <form @submit.prevent="submitPresensi('pulang')">
                      <button
                        type="submit"
                        :disabled="
                          formPulang.processing ||
                          !(presensiHariIni && presensiHariIni.jam_masuk) ||
                          (presensiHariIni && presensiHariIni.jam_pulang) ||
                          !userLocation.latitude
                        "
                        class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 disabled:opacity-50"
                      >
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
                      </button>
                    </form>
                  </div>
                </div>

                <!-- Info Jam Kerja -->
                <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                  <h3 class="font-semibold mb-2">Jam Kerja</h3>
                  <div class="grid grid-cols-3 gap-4 text-sm">
                    <div class="text-center">
                      <p class="font-medium text-green-600">Jam Masuk Normal</p>
                      <p>
                        {{
                          formatTime(pengaturan?.jam_masuk_normal) || "08:00"
                        }}
                      </p>
                    </div>
                    <div class="text-center">
                      <p class="font-medium text-yellow-600">Batas Telat</p>
                      <p>
                        {{ formatTime(pengaturan?.jam_masuk_telat) || "08:30" }}
                      </p>
                    </div>
                    <div class="text-center">
                      <p class="font-medium text-blue-600">Jam Pulang</p>
                      <p>
                        {{
                          formatTime(pengaturan?.jam_pulang_normal) || "16:00"
                        }}
                      </p>
                    </div>
                  </div>
                  <div class="mt-2 text-center">
                    <p class="text-sm text-gray-600">
                      Waktu Sekarang: {{ currentTime }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tabel Data Presensi -->
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Tanggal
                    </th>
                    <th
                      v-if="isAdmin"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Nama Guru
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Jam Masuk
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Status Masuk
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Jam Pulang
                    </th>
                    <th
                      v-if="isAdmin"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Lokasi
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="item in presensi.data" :key="item.id">
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                      {{ formatDateCorrect(item.tanggal) }}
                    </td>
                    <td
                      v-if="isAdmin"
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                      {{ item.user ? item.user.name : "N/A" }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                      {{ item.jam_masuk || "-" }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        :class="getStatusClass(item.status_masuk)"
                        class="px-2 py-1 text-xs font-semibold rounded-full"
                      >
                        {{ formatStatus(item.status_masuk) }}
                      </span>
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                      {{ item.jam_pulang || "-" }}
                    </td>
                    <td v-if="isAdmin" class="px-6 py-4 text-sm text-gray-900">
                      <div v-if="item.latitude_masuk">
                        <button
                          @click="showLocationModal(item)"
                          class="text-blue-600 hover:text-blue-800 underline"
                        >
                          Lihat Lokasi
                        </button>
                      </div>
                      <span v-else class="text-gray-500">-</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- No Data Message -->
            <div
              v-if="presensi.data && presensi.data.length === 0"
              class="text-center py-8"
            >
              <p class="text-gray-500">Belum ada data presensi.</p>
            </div>

            <!-- Location Modal -->
            <div
              v-if="showLocationInfo"
              class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
            >
              <div
                class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
              >
                <div class="mt-3">
                  <h3 class="text-lg font-bold text-gray-900 mb-4">
                    Informasi Lokasi Presensi
                  </h3>
                  <div class="space-y-3">
                    <div>
                      <p class="font-medium">Tanggal:</p>
                      <p class="text-sm text-gray-600">
                        {{ formatDateCorrect(selectedPresensi?.tanggal) }}
                      </p>
                    </div>
                    <div>
                      <p class="font-medium">Nama Guru:</p>
                      <p class="text-sm text-gray-600">
                        {{ selectedPresensi?.user?.name }}
                      </p>
                    </div>
                    <div v-if="selectedPresensi?.latitude_masuk">
                      <p class="font-medium">Lokasi Masuk:</p>
                      <p class="text-sm text-gray-600">
                        {{ selectedPresensi.latitude_masuk }},
                        {{ selectedPresensi.longitude_masuk }}
                      </p>
                    </div>
                    <div v-if="selectedPresensi?.latitude_pulang">
                      <p class="font-medium">Lokasi Pulang:</p>
                      <p class="text-sm text-gray-600">
                        {{ selectedPresensi.latitude_pulang }},
                        {{ selectedPresensi.longitude_pulang }}
                      </p>
                    </div>
                  </div>
                  <div class="flex justify-end mt-6">
                    <button
                      @click="showLocationInfo = false"
                      class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                    >
                      Tutup
                    </button>
                  </div>
                </div>
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
          class: "bg-gray-100 text-gray-800",
        };
      }

      if (!props.pengaturan?.latitude_sekolah) {
        return {
          text: "Koordinat sekolah belum diatur",
          class: "bg-orange-100 text-orange-800",
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
          class: "bg-green-100 text-green-800",
        };
      } else {
        return {
          text: `Di luar radius absensi (${Math.round(distance)}m)`,
          class: "bg-red-100 text-red-800",
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
          class: "bg-green-100 text-green-800",
        };
      } else if (currentTimeStr <= jamTelat) {
        return {
          text: "Masuk (Mendekati Telat)",
          class: "bg-yellow-100 text-yellow-800",
        };
      } else {
        return {
          text: "Telat",
          class: "bg-red-100 text-red-800",
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
          console.log("Location updated:", userLocation.value);
        },
        (error) => {
          gettingLocation.value = false;
          console.error("Geolocation error:", error);
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
        formMasuk.post("/presensi", {
          onSuccess: () => {
            // Form akan di-reset otomatis
          },
          onError: (errors) => {
            console.error("Presensi error:", errors);
          },
        });
      } else {
        formPulang.latitude = userLocation.value.latitude;
        formPulang.longitude = userLocation.value.longitude;
        formPulang.post("/presensi", {
          onError: (errors) => {
            console.error("Presensi error:", errors);
          },
        });
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

    // Format tanggal yang benar dengan timezone
    const formatDateCorrect = (dateString) => {
      if (!dateString) return "";

      // Parse tanggal dari string database (format: YYYY-MM-DD)
      const dateParts = dateString.split("-");
      const year = parseInt(dateParts[0]);
      const month = parseInt(dateParts[1]) - 1; // Month is 0-indexed
      const day = parseInt(dateParts[2]);

      const date = new Date(year, month, day);

      return date.toLocaleDateString("id-ID", {
        weekday: "long",
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
        masuk: "bg-green-100 text-green-800",
        telat: "bg-yellow-100 text-yellow-800",
        alpha: "bg-red-100 text-red-800",
        izin: "bg-blue-100 text-blue-800",
      };
      return classMap[status] || "bg-gray-100 text-gray-800";
    };

    let timeInterval;
    onMounted(() => {
      updateCurrentTime();
      timeInterval = setInterval(updateCurrentTime, 1000);

      // Auto-ambil lokasi saat halaman dimuat (jika bukan admin)
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
