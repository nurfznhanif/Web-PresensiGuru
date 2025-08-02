<template>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">
              {{ isAdmin ? "Data Presensi Guru" : "Presensi Saya" }}
            </h1>

            <!-- Debug Info -->
            <div class="mb-4 p-4 bg-yellow-100 rounded">
              <p><strong>Debug:</strong> Halaman berhasil dimuat!</p>
              <p><strong>Role:</strong> {{ isAdmin ? "Admin" : "Guru" }}</p>
              <p>
                <strong>Total Data:</strong>
                {{ presensi.data ? presensi.data.length : 0 }}
              </p>
            </div>

            <!-- Form Presensi untuk Guru -->
            <div v-if="!isAdmin" class="mb-8">
              <div class="bg-blue-50 p-6 rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Presensi Hari Ini</h2>

                <div
                  v-if="presensiHariIni"
                  class="mb-4 p-4 bg-green-100 rounded"
                >
                  <p>
                    <strong>Status Masuk:</strong>
                    {{ presensiHariIni.status_masuk }}
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
                    <form @submit.prevent="submitPresensi('masuk')">
                      <div class="mb-3">
                        <label class="block text-sm font-medium mb-1"
                          >Status</label
                        >
                        <select
                          v-model="formMasuk.status"
                          required
                          class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500"
                          :disabled="
                            presensiHariIni && presensiHariIni.jam_masuk
                          "
                        >
                          <option value="">Pilih Status</option>
                          <option value="masuk">Masuk</option>
                          <option value="telat">Telat</option>
                          <option value="izin">Izin</option>
                        </select>
                      </div>

                      <div class="mb-3">
                        <label class="block text-sm font-medium mb-1"
                          >Keterangan</label
                        >
                        <textarea
                          v-model="formMasuk.keterangan"
                          class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500"
                          rows="2"
                          :disabled="
                            presensiHariIni && presensiHariIni.jam_masuk
                          "
                        ></textarea>
                      </div>

                      <button
                        type="submit"
                        :disabled="
                          formMasuk.processing ||
                          (presensiHariIni && presensiHariIni.jam_masuk)
                        "
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 disabled:opacity-50"
                      >
                        {{
                          presensiHariIni && presensiHariIni.jam_masuk
                            ? "Sudah Presensi"
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
                          (presensiHariIni && presensiHariIni.jam_pulang)
                        "
                        class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 disabled:opacity-50"
                      >
                        {{
                          !(presensiHariIni && presensiHariIni.jam_masuk)
                            ? "Presensi Masuk Dulu"
                            : presensiHariIni && presensiHariIni.jam_pulang
                            ? "Sudah Presensi Pulang"
                            : "Presensi Pulang"
                        }}
                      </button>
                    </form>
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
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Keterangan
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="item in presensi.data" :key="item.id">
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                      {{ formatDate(item.tanggal) }}
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
                    <td class="px-6 py-4 text-sm text-gray-900">
                      {{ item.keterangan || "-" }}
                    </td>
                  </tr>
                </tbody>
              </table>
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
  },
  setup() {
    const formMasuk = useForm({
      type: "masuk",
      status: "",
      keterangan: "",
    });

    const formPulang = useForm({
      type: "pulang",
    });

    const submitPresensi = (type) => {
      if (type === "masuk") {
        formMasuk.post("/presensi", {
          onSuccess: () => {
            formMasuk.reset("status", "keterangan");
          },
        });
      } else {
        formPulang.post("/presensi");
      }
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

    return {
      formMasuk,
      formPulang,
      submitPresensi,
      formatDate,
      formatStatus,
      getStatusClass,
    };
  },
};
</script>
