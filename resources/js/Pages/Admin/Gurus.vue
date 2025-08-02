<template>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-2xl font-bold text-gray-900">Data Guru</h1>
              <button
                @click="showAddForm = true"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              >
                Tambah Guru
              </button>
            </div>

            <!-- Add Guru Modal -->
            <div
              v-if="showAddForm"
              class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
            >
              <div
                class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
              >
                <div class="mt-3">
                  <h3 class="text-lg font-bold text-gray-900 mb-4">
                    Tambah Guru Baru
                  </h3>
                  <form @submit.prevent="submitForm">
                    <div class="mb-4">
                      <label class="block text-gray-700 text-sm font-bold mb-2"
                        >Nama</label
                      >
                      <input
                        v-model="form.name"
                        type="text"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': formErrors.name }"
                      />
                      <div
                        v-if="formErrors.name"
                        class="text-red-500 text-sm mt-1"
                      >
                        {{ formErrors.name[0] }}
                      </div>
                    </div>

                    <div class="mb-4">
                      <label class="block text-gray-700 text-sm font-bold mb-2"
                        >Email</label
                      >
                      <input
                        v-model="form.email"
                        type="email"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': formErrors.email }"
                      />
                      <div
                        v-if="formErrors.email"
                        class="text-red-500 text-sm mt-1"
                      >
                        {{ formErrors.email[0] }}
                      </div>
                    </div>

                    <div class="mb-4">
                      <label class="block text-gray-700 text-sm font-bold mb-2"
                        >NIP</label
                      >
                      <input
                        v-model="form.nip"
                        type="text"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': formErrors.nip }"
                      />
                      <div
                        v-if="formErrors.nip"
                        class="text-red-500 text-sm mt-1"
                      >
                        {{ formErrors.nip[0] }}
                      </div>
                    </div>

                    <div class="mb-6">
                      <label class="block text-gray-700 text-sm font-bold mb-2"
                        >Password</label
                      >
                      <input
                        v-model="form.password"
                        type="password"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': formErrors.password }"
                      />
                      <div
                        v-if="formErrors.password"
                        class="text-red-500 text-sm mt-1"
                      >
                        {{ formErrors.password[0] }}
                      </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                      <button
                        type="button"
                        @click="closeForm"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                      >
                        Batal
                      </button>
                      <button
                        type="submit"
                        :disabled="isSubmitting"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                      >
                        {{ isSubmitting ? "Menyimpan..." : "Simpan" }}
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Guru Table -->
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Nama
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Email
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      NIP
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Status Presensi Hari Ini
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Jam Masuk
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Jam Pulang
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="guru in gurus" :key="guru.id">
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                    >
                      {{ guru.name }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                      {{ guru.email }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                      {{ guru.nip }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        v-if="guru.presensi_hari_ini"
                        :class="
                          getStatusClass(guru.presensi_hari_ini.status_masuk)
                        "
                        class="px-2 py-1 text-xs font-semibold rounded-full"
                      >
                        {{ formatStatus(guru.presensi_hari_ini.status_masuk) }}
                      </span>
                      <span
                        v-else
                        class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800"
                      >
                        Belum Presensi
                      </span>
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                      {{ guru.presensi_hari_ini?.jam_masuk || "-" }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                      {{ guru.presensi_hari_ini?.jam_pulang || "-" }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- No Data Message -->
            <div v-if="gurus.length === 0" class="text-center py-8">
              <p class="text-gray-500">Belum ada data guru.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, reactive, onMounted } from "vue";
import axios from "axios";

export default {
  components: {
    AppLayout,
  },
  setup() {
    const gurus = ref([]);
    const showAddForm = ref(false);
    const isSubmitting = ref(false);
    const formErrors = ref({});

    const form = reactive({
      name: "",
      email: "",
      nip: "",
      password: "",
    });

    const fetchGurus = async () => {
      try {
        const response = await axios.get("/api/gurus");
        gurus.value = response.data.data;
      } catch (error) {
        console.error("Error fetching gurus:", error);
      }
    };

    const submitForm = async () => {
      isSubmitting.value = true;
      formErrors.value = {};

      try {
        const response = await axios.post("/api/gurus", form);

        // Add new guru to list
        gurus.value.push(response.data.data);

        // Reset form and close modal
        closeForm();

        // Show success message (you can use toast or alert)
        alert("Guru berhasil ditambahkan!");
      } catch (error) {
        if (error.response && error.response.status === 422) {
          formErrors.value = error.response.data.errors;
        } else {
          alert("Terjadi kesalahan saat menyimpan data");
        }
      } finally {
        isSubmitting.value = false;
      }
    };

    const closeForm = () => {
      showAddForm.value = false;
      formErrors.value = {};
      Object.keys(form).forEach((key) => {
        form[key] = "";
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

    // Auto-refresh data every 30 seconds for real-time updates
    let refreshInterval;
    onMounted(() => {
      fetchGurus();
      refreshInterval = setInterval(fetchGurus, 30000);
    });

    return {
      gurus,
      showAddForm,
      isSubmitting,
      formErrors,
      form,
      submitForm,
      closeForm,
      formatStatus,
      getStatusClass,
    };
  },
};
</script>
