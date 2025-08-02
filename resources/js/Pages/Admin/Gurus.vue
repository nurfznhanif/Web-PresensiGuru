<template>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-2xl font-bold text-gray-900">Data Guru</h1>
              <button
                @click="openAddForm"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              >
                Tambah Guru
              </button>
            </div>

            <!-- Modal Form -->
            <div
              v-if="showForm"
              class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
            >
              <div
                class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
              >
                <div class="mt-3">
                  <h3 class="text-lg font-bold text-gray-900 mb-4">
                    {{ editMode ? "Edit Guru" : "Tambah Guru Baru" }}
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
                      <label class="block text-gray-700 text-sm font-bold mb-2">
                        Password
                        {{
                          editMode
                            ? "(Kosongkan jika tidak ingin mengubah)"
                            : ""
                        }}
                      </label>
                      <input
                        v-model="form.password"
                        type="password"
                        :required="!editMode"
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

            <!-- Confirmation Modal -->
            <div
              v-if="showDeleteConfirm"
              class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
            >
              <div
                class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
              >
                <div class="mt-3 text-center">
                  <h3 class="text-lg font-bold text-gray-900 mb-4">
                    Konfirmasi Hapus
                  </h3>
                  <p class="text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus guru
                    <strong>{{ deleteTarget?.name }}</strong
                    >?
                    <br />
                    <span class="text-red-600 text-sm"
                      >Data presensi guru ini juga akan ikut terhapus!</span
                    >
                  </p>
                  <div class="flex justify-center space-x-2">
                    <button
                      @click="showDeleteConfirm = false"
                      class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                    >
                      Batal
                    </button>
                    <button
                      @click="confirmDelete"
                      :disabled="isDeleting"
                      class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                    >
                      {{ isDeleting ? "Menghapus..." : "Hapus" }}
                    </button>
                  </div>
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
                      Tanggal Daftar
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
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      Aksi
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
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                      {{ formatDate(guru.created_at) }}
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <div class="flex space-x-2">
                        <button
                          @click="openEditForm(guru)"
                          class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-xs"
                        >
                          Edit
                        </button>
                        <button
                          @click="openDeleteConfirm(guru)"
                          class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs"
                        >
                          Hapus
                        </button>
                      </div>
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
    const showForm = ref(false);
    const showDeleteConfirm = ref(false);
    const editMode = ref(false);
    const isSubmitting = ref(false);
    const isDeleting = ref(false);
    const formErrors = ref({});
    const deleteTarget = ref(null);

    const form = reactive({
      id: null,
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
          // Update guru in list
          const index = gurus.value.findIndex((g) => g.id === form.id);
          if (index !== -1) {
            gurus.value[index] = {
              ...gurus.value[index],
              ...response.data.data,
            };
          }
        } else {
          response = await axios.post("/api/gurus", form);
          // Add new guru to list
          gurus.value.push(response.data.data);
        }

        closeForm();
        alert(
          editMode.value
            ? "Data guru berhasil diperbarui!"
            : "Guru berhasil ditambahkan!"
        );
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

    const openDeleteConfirm = (guru) => {
      deleteTarget.value = guru;
      showDeleteConfirm.value = true;
    };

    const confirmDelete = async () => {
      isDeleting.value = true;

      try {
        await axios.delete(`/api/gurus/${deleteTarget.value.id}`);

        // Remove guru from list
        gurus.value = gurus.value.filter((g) => g.id !== deleteTarget.value.id);

        showDeleteConfirm.value = false;
        deleteTarget.value = null;
        alert("Data guru berhasil dihapus!");
      } catch (error) {
        alert("Terjadi kesalahan saat menghapus data");
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
        masuk: "bg-green-100 text-green-800",
        telat: "bg-yellow-100 text-yellow-800",
        alpha: "bg-red-100 text-red-800",
        izin: "bg-blue-100 text-blue-800",
      };
      return classMap[status] || "bg-gray-100 text-gray-800";
    };

    onMounted(() => {
      fetchGurus();
      // Auto-refresh every 30 seconds
      setInterval(fetchGurus, 30000);
    });

    return {
      gurus,
      showForm,
      showDeleteConfirm,
      editMode,
      isSubmitting,
      isDeleting,
      formErrors,
      deleteTarget,
      form,
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
