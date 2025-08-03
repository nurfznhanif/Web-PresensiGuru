<template>
  <div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 flex items-center justify-center px-4 sm:px-6 lg:px-8 relative overflow-hidden"
  >
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 pointer-events-none">
      <div
        class="absolute top-1/4 left-1/4 w-72 h-72 bg-blue-200/30 rounded-full blur-3xl animate-float"
      ></div>
      <div
        class="absolute top-3/4 right-1/4 w-96 h-96 bg-cyan-200/30 rounded-full blur-3xl animate-float-delayed"
      ></div>
      <div
        class="absolute top-1/2 left-3/4 w-64 h-64 bg-indigo-200/20 rounded-full blur-3xl animate-pulse"
      ></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative z-10">
      <!-- Header Section -->
      <div class="text-center">
        <!-- Logo -->
        <div
          class="mx-auto w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-2xl transform hover:scale-110 transition-all duration-300 mb-6"
        >
          <svg
            class="w-10 h-10 text-white"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
            />
          </svg>
        </div>

        <h2
          class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-2"
        >
          SD 003 YKWI PEKANBARU
        </h2>
        <p class="text-lg font-semibold text-slate-600 mb-2">
          Sistem Presensi Digital
        </p>
        <p class="text-sm text-slate-500">Silakan masuk dengan akun Anda</p>
      </div>

      <!-- Login Form -->
      <div
        class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-3xl p-8 border border-white/20"
      >
        <form @submit.prevent="login" class="space-y-6">
          <!-- Email Input -->
          <div class="space-y-2">
            <label
              class="text-sm font-semibold text-slate-700 flex items-center"
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
                  d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                />
              </svg>
              Email Address
            </label>
            <div class="relative">
              <input
                v-model="form.email"
                type="email"
                required
                class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 placeholder-slate-400"
                :class="{ 'border-red-400 ring-red-200': errors.email }"
                placeholder="Masukkan email Anda"
              />
              <div
                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
              >
                <svg
                  v-if="form.email"
                  class="h-5 w-5 text-green-400"
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
              </div>
            </div>
            <div
              v-if="errors.email"
              class="text-red-500 text-sm flex items-center"
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
              {{ errors.email }}
            </div>
          </div>

          <!-- Password Input -->
          <div class="space-y-2">
            <label
              class="text-sm font-semibold text-slate-700 flex items-center"
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
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                />
              </svg>
              Password
            </label>
            <div class="relative">
              <input
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                required
                class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 placeholder-slate-400 pr-12"
                :class="{ 'border-red-400 ring-red-200': errors.password }"
                placeholder="Masukkan password Anda"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
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
              v-if="errors.password"
              class="text-red-500 text-sm flex items-center"
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
              {{ errors.password }}
            </div>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="processing"
            class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center space-x-2"
          >
            <svg
              v-if="processing"
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
            <span>{{ processing ? "Memproses..." : "Masuk" }}</span>
            <svg
              v-if="!processing"
              class="w-5 h-5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13 7l5 5m0 0l-5 5m5-5H6"
              />
            </svg>
          </button>
        </form>
      </div>

      <!-- Demo Accounts -->
      <div
        class="bg-white/60 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-lg"
      >
        <div class="text-center">
          <h3
            class="text-lg font-semibold text-slate-700 mb-4 flex items-center justify-center"
          >
            <svg
              class="w-5 h-5 mr-2 text-blue-500"
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
            Akun Demo
          </h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Admin Demo -->
            <div
              class="bg-gradient-to-br from-purple-50 to-indigo-50 p-4 rounded-xl border border-purple-100 hover:shadow-md transition-all duration-300 cursor-pointer"
              @click="fillDemoData('admin')"
            >
              <div class="flex items-center justify-center mb-2">
                <div
                  class="w-8 h-8 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center"
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
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                    />
                  </svg>
                </div>
              </div>
              <p class="font-semibold text-purple-700 text-sm">Administrator</p>
              <p class="text-xs text-purple-600 font-medium">
                admin@sekolah.com
              </p>
              <p class="text-xs text-purple-500">password</p>
            </div>

            <!-- Guru Demo -->
            <div
              class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-xl border border-green-100 hover:shadow-md transition-all duration-300 cursor-pointer"
              @click="fillDemoData('guru')"
            >
              <div class="flex items-center justify-center mb-2">
                <div
                  class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center"
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
              </div>
              <p class="font-semibold text-green-700 text-sm">Guru</p>
              <p class="text-xs text-green-600 font-medium">budi@sekolah.com</p>
              <p class="text-xs text-green-500">password</p>
            </div>
          </div>
          <p class="text-xs text-slate-500 mt-3">
            Klik pada kartu untuk mengisi data login secara otomatis
          </p>
        </div>
      </div>

      <!-- Footer -->
      <div class="text-center">
        <p class="text-sm text-slate-500">
          © 2024 SD 003 YKWI Pekanbaru.
          <span class="font-medium text-blue-600">Sistem Presensi Digital</span>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

export default {
  props: {
    errors: {
      type: Object,
      default: () => ({}),
    },
  },
  setup() {
    const showPassword = ref(false);

    const form = useForm({
      email: "",
      password: "",
    });

    const login = () => {
      form.post("/login");
    };

    const fillDemoData = (type) => {
      if (type === "admin") {
        form.email = "admin@sekolah.com";
        form.password = "password";
      } else {
        form.email = "budi@sekolah.com";
        form.password = "password";
      }
    };

    return {
      form,
      login,
      processing: form.processing,
      showPassword,
      fillDemoData,
    };
  },
};
</script>

<style scoped>
@keyframes float {
  0%,
  100% {
    transform: translateY(0px) translateX(0px) rotate(0deg);
  }
  33% {
    transform: translateY(-20px) translateX(10px) rotate(1deg);
  }
  66% {
    transform: translateY(10px) translateX(-10px) rotate(-1deg);
  }
}

@keyframes float-delayed {
  0%,
  100% {
    transform: translateY(0px) translateX(0px) rotate(0deg);
  }
  33% {
    transform: translateY(15px) translateX(-15px) rotate(-1deg);
  }
  66% {
    transform: translateY(-10px) translateX(15px) rotate(1deg);
  }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
  animation: float-delayed 8s ease-in-out infinite;
}
</style>
