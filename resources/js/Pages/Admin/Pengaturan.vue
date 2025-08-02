<template>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">
              Pengaturan Sistem
            </h1>

            <form @submit.prevent="submitForm">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pengaturan Jam Kerja -->
                <div class="bg-gray-50 p-6 rounded-lg">
                  <h2 class="text-lg font-semibold mb-4">
                    Pengaturan Jam Kerja
                  </h2>

                  <div class="space-y-4">
                    <div>
                      <label
                        class="block text-sm font-medium text-gray-700 mb-1"
                      >
                        Jam Masuk Normal
                      </label>
                      <input
                        v-model="form.jam_masuk_normal"
                        type="time"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': errors.jam_masuk_normal }"
                      />
                      <div
                        v-if="errors.jam_masuk_normal"
                        class="text-red-500 text-sm mt-1"
                      >
                        {{ errors.jam_masuk_normal }}
                      </div>
                    </div>

                    <div>
                      <label
                        class="block text-sm font-medium text-gray-700 mb-1"
                      >
                        Batas Waktu Telat
                      </label>
                      <input
                        v-model="form.jam_masuk_telat"
                        type="time"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': errors.jam_masuk_telat }"
                      />
                      <div
                        v-if="errors.jam_masuk_telat"
                        class="text-red-500 text-sm mt-1"
                      >
                        {{ errors.jam_masuk_telat }}
                      </div>
                    </div>

                    <div>
                      <label
                        class="block text-sm font-medium text-gray-700 mb-1"
                      >
                        Jam Pulang Normal
                      </label>
                      <input
                        v-model="form.jam_pulang_normal"
                        type="time"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': errors.jam_pulang_normal }"
                      />
                      <div
                        v-if="errors.jam_pulang_normal"
                        class="text-red-500 text-sm mt-1"
                      >
                        {{ errors.jam_pulang_normal }}
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Pengaturan Lokasi -->
                <div class="bg-gray-50 p-6 rounded-lg">
                  <h2 class="text-lg font-semibold mb-4">
                    Pengaturan Lokasi Absensi
                  </h2>

                  <div class="space-y-4">
                    <div>
                      <label
                        class="block text-sm font-medium text-gray-700 mb-1"
                      >
                        Nama Lokasi
                      </label>
                      <input
                        v-model="form.nama_lokasi"
                        type="text"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': errors.nama_lokasi }"
                      />
                      <div
                        v-if="errors.nama_lokasi"
                        class="text-red-500 text-sm mt-1"
                      >
                        {{ errors.nama_lokasi }}
                      </div>
                    </div>

                    <div>
                      <label
                        class="block text-sm font-medium text-gray-700 mb-1"
                      >
                        Alamat Lokasi
                      </label>
                      <textarea
                        v-model="form.alamat_lokasi"
                        rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': errors.alamat_lokasi }"
                      ></textarea>
                      <div
                        v-if="errors.alamat_lokasi"
                        class="text-red-500 text-sm mt-1"
                      >
                        {{ errors.alamat_lokasi }}
                      </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                      <div>
                        <label
                          class="block text-sm font-medium text-gray-700 mb-1"
                        >
                          Latitude
                        </label>
                        <input
                          v-model="form.latitude_sekolah"
                          type="number"
                          step="any"
                          required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          :class="{ 'border-red-500': errors.latitude_sekolah }"
                        />
                        <div
                          v-if="errors.latitude_sekolah"
                          class="text-red-500 text-sm mt-1"
                        >
                          {{ errors.latitude_sekolah }}
                        </div>
                      </div>

                      <div>
                        <label
                          class="block text-sm font-medium text-gray-700 mb-1"
                        >
                          Longitude
                        </label>
                        <input
                          v-model="form.longitude_sekolah"
                          type="number"
                          step="any"
                          required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          :class="{
                            'border-red-500': errors.longitude_sekolah,
                          }"
                        />
                        <div
                          v-if="errors.longitude_sekolah"
                          class="text-red-500 text-sm mt-1"
                        >
                          {{ errors.longitude_sekolah }}
                        </div>
                      </div>
                    </div>

                    <div>
                      <label
                        class="block text-sm font-medium text-gray-700 mb-1"
                      >
                        Radius Absensi (meter)
                      </label>
                      <input
                        v-model="form.radius_absensi"
                        type="number"
                        min="10"
                        max="1000"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': errors.radius_absensi }"
                      />
                      <div
                        v-if="errors.radius_absensi"
                        class="text-red-500 text-sm mt-1"
                      >
                        {{ errors.radius_absensi }}
                      </div>
                      <p class="text-sm text-gray-500 mt-1">
                        Jarak maksimal dari lokasi sekolah untuk bisa absen
                      </p>
                    </div>

                    <div class="mt-4">
                      <button
                        type="button"
                        @click="getCurrentLocation"
                        :disabled="gettingLocation"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                      >
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

              <!-- Map Preview -->
              <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Preview Lokasi</h2>
                <div
                  class="bg-gray-200 h-64 rounded-lg flex items-center justify-center"
                >
                  <div class="text-center text-gray-600">
                    <p class="font-semibold">
                      {{ form.nama_lokasi || "Nama Lokasi" }}
                    </p>
                    <p class="text-sm">
                      {{ form.alamat_lokasi || "Alamat lokasi" }}
                    </p>
                    <p class="text-sm mt-2">
                      Koordinat: {{ form.latitude_sekolah }},
                      {{ form.longitude_sekolah }}
                    </p>
                    <p class="text-sm">
                      Radius: {{ form.radius_absensi }} meter
                    </p>
                  </div>
                </div>
                <p class="text-sm text-gray-500 mt-2">
                  *Untuk menggunakan peta interaktif, integrasikan dengan Google
                  Maps API
                </p>
              </div>

              <!-- Submit Button -->
              <div class="mt-6 flex justify-end">
                <button
                  type="submit"
                  :disabled="processing"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded disabled:opacity-50"
                >
                  {{ processing ? "Menyimpan..." : "Simpan Pengaturan" }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";

export default {
  components: {
    AppLayout,
  },
  props: {
    pengaturan: Object,
    errors: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    const gettingLocation = ref(false);

    const form = useForm({
      jam_masuk_normal: props.pengaturan.jam_masuk_normal || "08:00",
      jam_masuk_telat: props.pengaturan.jam_masuk_telat || "08:30",
      jam_pulang_normal: props.pengaturan.jam_pulang_normal || "16:00",
      latitude_sekolah: props.pengaturan.latitude_sekolah || "",
      longitude_sekolah: props.pengaturan.longitude_sekolah || "",
      radius_absensi: props.pengaturan.radius_absensi || 100,
      nama_lokasi: props.pengaturan.nama_lokasi || "",
      alamat_lokasi: props.pengaturan.alamat_lokasi || "",
    });

    const submitForm = () => {
      form.put("/admin/pengaturan");
    };

    const getCurrentLocation = () => {
      if (!navigator.geolocation) {
        alert("Geolokasi tidak didukung oleh browser ini.");
        return;
      }

      gettingLocation.value = true;

      navigator.geolocation.getCurrentPosition(
        (position) => {
          form.latitude_sekolah = position.coords.latitude;
          form.longitude_sekolah = position.coords.longitude;
          gettingLocation.value = false;
        },
        (error) => {
          gettingLocation.value = false;
          alert("Gagal mendapatkan lokasi: " + error.message);
        },
        {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 0,
        }
      );
    };

    return {
      form,
      submitForm,
      getCurrentLocation,
      gettingLocation,
      processing: form.processing,
    };
  },
};
</script>
