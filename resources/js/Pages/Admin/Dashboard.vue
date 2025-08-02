<template>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">
              Dashboard Admin
            </h1>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
              <div class="bg-blue-100 p-6 rounded-lg">
                <div class="flex items-center">
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-blue-800">
                      Total Guru
                    </h3>
                    <p class="text-3xl font-bold text-blue-900">
                      {{ stats.total_guru }}
                    </p>
                  </div>
                  <div class="text-blue-500">
                    <svg
                      class="w-12 h-12"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                </div>
              </div>

              <div class="bg-green-100 p-6 rounded-lg">
                <div class="flex items-center">
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-green-800">
                      Presensi Hari Ini
                    </h3>
                    <p class="text-3xl font-bold text-green-900">
                      {{ stats.presensi_hari_ini }}
                    </p>
                  </div>
                  <div class="text-green-500">
                    <svg
                      class="w-12 h-12"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      />
                    </svg>
                  </div>
                </div>
              </div>

              <div class="bg-yellow-100 p-6 rounded-lg">
                <div class="flex items-center">
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-yellow-800">
                      Telat Hari Ini
                    </h3>
                    <p class="text-3xl font-bold text-yellow-900">
                      {{ stats.telat_hari_ini }}
                    </p>
                  </div>
                  <div class="text-yellow-500">
                    <svg
                      class="w-12 h-12"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </div>
                </div>
              </div>

              <div class="bg-red-100 p-6 rounded-lg">
                <div class="flex items-center">
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-red-800">
                      Alpha Hari Ini
                    </h3>
                    <p class="text-3xl font-bold text-red-900">
                      {{ stats.alpha_hari_ini }}
                    </p>
                  </div>
                  <div class="text-red-500">
                    <svg
                      class="w-12 h-12"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </div>
                </div>
              </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                <div class="space-y-3">
                  <Link
                    href="/admin/gurus"
                    class="block bg-blue-500 text-white text-center py-2 px-4 rounded hover:bg-blue-600"
                  >
                    Kelola Data Guru
                  </Link>
                  <Link
                    href="/presensi"
                    class="block bg-green-500 text-white text-center py-2 px-4 rounded hover:bg-green-600"
                  >
                    Lihat Data Presensi
                  </Link>
                </div>
              </div>

              <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Informasi Sistem</h3>
                <div class="space-y-2 text-sm text-gray-600">
                  <p><strong>Tanggal:</strong> {{ currentDate }}</p>
                  <p><strong>Waktu:</strong> {{ currentTime }}</p>
                  <p>
                    <strong>Status:</strong>
                    <span class="text-green-600">Online</span>
                  </p>
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
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted, onUnmounted } from "vue";

export default {
  components: {
    AppLayout,
    Link,
  },
  props: {
    stats: Object,
  },
  setup() {
    const currentDate = ref("");
    const currentTime = ref("");
    let timeInterval = null;

    const updateDateTime = () => {
      const now = new Date();
      currentDate.value = now.toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });
      currentTime.value = now.toLocaleTimeString("id-ID");
    };

    onMounted(() => {
      updateDateTime();
      timeInterval = setInterval(updateDateTime, 1000);
    });

    onUnmounted(() => {
      if (timeInterval) {
        clearInterval(timeInterval);
      }
    });

    return {
      currentDate,
      currentTime,
    };
  },
};
</script>
