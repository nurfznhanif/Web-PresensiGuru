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
                  <h3 class="font-semibold text-yellow-800 mb-2">Informasi Lokasi Absensi</h3>
                  <p class="text-sm text-yellow-700">
                    <strong>{{ pengaturan.nama_lokasi }}</strong><br>
                    {{ pengaturan.alamat_lokasi }}<br>
                    Radius absensi: {{ pengaturan.radius_absensi }} meter
                  </p>
                  <div class="mt-2">
                    <span
                      :class="locationStatus.class"
                      class="px-2 py-1 text-xs font-semibold rounded-full"
                    >
                      {{ locationStatus.text }}
                    </span>
                  </div>
                </div>

                <div v-if="presensiHariIni" class="mb-4 p-4 bg-green-100 rounded">
                  <p><strong>Status Masuk:</strong> {{ formatStatus(presensiHariIni.status_masuk) }}</p>
                  <p v-if="presensiHariIni.jam_masuk">
                    <strong>Jam Masuk:</strong> {{ presensiHariIni.jam_masuk }}
                  </p>
                  <p v-if="presensiHariIni.jam_pulang">
                    <strong>Jam Pulang:</strong> {{ presensiHariIni.jam_pulang }}
                  </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <!-- Form Presensi Masuk -->
                  <div class="border p-4 rounded">
                    <h3 class="font-semibold mb-3">Presensi Masuk</h3>
                    <form @submit.prevent="submitPresensi('masuk')">
                      <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select
                          v-model="formMasuk.status"
                          required
                          class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500"
                          :disabled="presensiHariIni && presensiHariIni.jam_masuk"
                        >
                          <option value="">Pilih Status</option>
                          <option value="masuk">Masuk</option>
                          <option value="telat">Telat</option>
                          <option value="izin">Izin</option>
                        </select>
                      </div>

                      <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Keterangan</label>
                        <textarea
                          v-model="formMasuk.keterangan"
                          class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500"
                          rows="2"
                          :disabled="presensiHariIni && presensiHariIni.jam_masuk"
                        ></textarea>
                      </div>

                      <button
                        type="submit"
                        :disabled="
                          formMasuk.processing ||
                          (presensiHariIni && presensiHariIni.jam_masuk) ||
                          (formMasuk.status !== 'izin' && !userLocation.latitude)
                        "
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 disabled:opacity-50"
                      >
                        {{
                          presensiHariIni && presensiHariIni.jam_masuk
                            ? "Sudah Presensi"
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
                      <p>{{ pengaturan.jam_masuk_normal }}</p>
                    </div>
                    <div class="text-center">
                      <p class="font-medium text-yellow-600">Batas Telat</p>
                      <p>{{ pengaturan.jam_masuk_telat }}</p>
                    </div>
                    <div class="text-center">
                      <p class="font-medium text-blue-600">Jam Pulang</p>
                      <p>{{ pengaturan.jam_pulang_normal }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tabel Data Presensi -->
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Tanggal
                    </th>
                    <th v-if="isAdmin" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Nama Guru
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Jam Masuk
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Status Masuk
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Jam Pulang
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Keterangan
                    </th>
                    <th v-if="isAdmin" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Lokasi
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="item in presensi.data" :key="item.id">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ formatDate(item.tanggal) }}
                    </td>
                    <td v-if="isAdmin" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ item.user ? item.user.name : "N/A" }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ item.jam_pulang || "-" }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                      {{ item.keterangan || "-" }}
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

            <!-- Location Modal -->
            <div
              v-if="showLocationInfo"
              class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
            >
              <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                  <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Lokasi Presensi</h3>
                  <div class="space-y-3">
                    <div>
                      <p class="font-medium">Tanggal:</p>
                      <p class="text-sm text-gray-600">{{ formatDate(selectedPresensi?.tanggal) }}</p>
                    </div>
                    <div>
                      <p class="font-medium">Nama Guru:</p>
                      <p class="text-sm text-gray-600">{{ selectedPresensi?.user?.name }}</p>
                    </div>
                    <div v-if="selectedPresensi?.latitude_masuk">
                      <p class="font-medium">Lokasi Masuk:</p>
                      <p class="text-sm text-gray-600">
                        {{ selectedPresensi.latitude_masuk }}, {{ selectedPresensi.longitude_masuk }}
                      </p>
                    </div>
                    <div v-if="selectedPresensi?.latitude_pulang">
                      <p class="font-medium">Lokasi Pulang:</p>
                      <p class="text-sm text-gray-600">
                        {{ selectedPresensi.latitude_pulang }}, {{ selectedPresensi.longitude_pulang }}
                      </p>
                    </div>
                    <div class="bg-gray-100 p-3 rounded">
                      <p class="text-sm text-gray-600">
                        *Untuk melihat peta lengkap, integrasikan dengan Google Maps API
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
import { ref, computed, onMounted } from "vue";

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

    const formMasuk = useForm({
      type: "masuk",
      status: "",
      keterangan: "",
      latitude: null,
      longitude: null,
    });

    const formPulang = useForm({
      type: "pulang",
      latitude: null,
      longitude: null,
    });

    const locationStatus = computed(() => {
      if (!userLocation.value.latitude) {
        return {
          text: "Lokasi belum dideteksi",
          class: "bg-gray-100 text-gray-800"
        };
      }

      const distance = calculateDistance(
        userLocation.value.latitude,
        userLocation.value.longitude,
        props.pengaturan.latitude_sekolah,
        props.pengaturan.longitude_sekolah
      );

      if (distance <= props.pengaturan.radius_absensi) {
        return {
          text: `Dalam radius absensi (${Math.round(distance)}m)`,
          class: "bg-green-100 text-green-800"
        };
      } else {
        return {
          text: `Di luar radius absensi (${Math.round(distance)}m)`,
          class: "bg-red-100 text-red-800"
        };
      }
    });

    const getCurrentLocation = () => {
      if (!navigator.geolocation) {
        alert('Geolokasi tidak didukung oleh browser ini.');
        return Promise.reject();
      }

      gettingLocation.value = true;

      return new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            userLocation.value = {
              latitude: position.coords.latitude,
              longitude: position.coords.longitude,
            };
            gettingLocation.value = false;
            resolve(userLocation.value);
          },
          (error) => {
            gettingLocation.value = false;
            alert('Gagal mendapatkan lokasi: ' + error.message);
            reject(error);
          },
          {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000
          }
        );
      });
    };

    const submitPresensi = async (type) => {
      try {
        // Untuk izin, tidak perlu validasi lokasi
        if (type === 'masuk' && formMasuk.status === 'izin') {
          formMasuk.latitude = null;
          formMasuk.longitude = null;
          formMasuk.post("/presensi", {
            onSuccess: () => {
              formMasuk.reset("status", "keterangan");
            },
          });
          return;
        }

        // Untuk yang lain, ambil lokasi dulu
        if (!userLocation.value.latitude) {
          await getCurrentLocation();
        }

        if (type === "masuk") {
          formMasuk.latitude = userLocation.value.latitude;
          formMasuk.longitude = userLocation.value.longitude;
          formMasuk.post("/presensi", {
            onSuccess: () => {
              formMasuk.reset("status", "keterangan");
            },
          });
        } else {
          formPulang.latitude = userLocation.value.latitude;
          formPulang.longitude = userLocation.value.longitude;
          formPulang.post("/presensi");
        }
      } catch (error) {
        console.error('Error getting location:', error);
      }
    };

    const calculateDistance = (lat1, lon1, lat2, lon2) => {
      const R = 6371000; // Earth radius in meters
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLon = (lon2 - lon1) * Math.PI / 180;
      const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
      return R * c;
    };

    const showLocationModal = (presensi) => {
      selectedPresensi.value = presensi;
      showLocationInfo.value = true;
    };

    const formatDate = (date) => {
      return new Date(date).toLocaleDateString("id-ID", {
        weekday: "long",
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
        masuk: "bg-green-100 text-green-800",
        telat: "bg-yellow-100 text-yellow-800",
        alpha: "bg-red-100 text-red-800",
        izin: "bg-blue-100 text-blue-800",
      };
      return classMap[status] || "bg-gray-100 text-gray-800";
    };

    onMounted(() => {
      // Ambil lokasi saat halaman dimuat jika bukan admin
      if (!props.isAdmin) {
        getCurrentLocation().catch(() => {
          // Ignore error, user can manually trigger location
        });
      }
    });

    return {
      formMasuk,
      formPulang,
      userLocation,
      gettingLocation,
      locationStatus,
      showLocationInfo,
      selectedPresensi,
      submitPresensi,
      showLocationModal,
      formatDate,
      formatStatus,
      getStatusClass,
    };
  },
};
</script>
