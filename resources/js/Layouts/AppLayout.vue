<template>
  <div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50"
  >
    <!-- Navigation -->
    <nav
      class="bg-white/80 backdrop-blur-lg shadow-lg border-b border-blue-100/50 sticky top-0 z-50"
    >
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-20">
          <div class="flex items-center space-x-8">
            <!-- Logo -->
            <div class="flex-shrink-0">
              <div class="flex items-center space-x-3">
                <div
                  class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg hover:scale-105 transition-transform duration-300"
                >
                  <svg
                    class="w-7 h-7 text-white"
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
                <div>
                  <h1
                    class="text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent"
                  >
                    SD 003 YKWI PEKANBARU
                  </h1>
                  <p class="text-xs text-slate-500 font-medium">
                    Sistem Presensi Digital
                  </p>
                </div>
              </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:space-x-1">
              <Link
                v-if="$page.props.auth.user.role === 'admin'"
                href="/admin/dashboard"
                :class="[
                  'flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:scale-105',
                  $page.url === '/admin/dashboard'
                    ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg'
                    : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50',
                ]"
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
                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"
                  />
                </svg>
                Dashboard
              </Link>

              <Link
                v-if="$page.props.auth.user.role === 'admin'"
                href="/admin/gurus"
                :class="[
                  'flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:scale-105',
                  $page.url === '/admin/gurus'
                    ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg'
                    : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50',
                ]"
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
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"
                  />
                </svg>
                Data Guru
              </Link>

              <Link
                href="/presensi"
                :class="[
                  'flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:scale-105',
                  $page.url === '/presensi'
                    ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg'
                    : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50',
                ]"
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
                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                  />
                </svg>
                {{
                  $page.props.auth.user.role === "admin"
                    ? "Data Presensi"
                    : "Presensi Saya"
                }}
              </Link>

              <Link
                v-if="$page.props.auth.user.role === 'admin'"
                href="/admin/pengaturan"
                :class="[
                  'flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:scale-105',
                  $page.url === '/admin/pengaturan'
                    ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg'
                    : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50',
                ]"
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
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                  />
                </svg>
                Pengaturan
              </Link>
            </div>
          </div>

          <!-- User Info & Logout -->
          <div class="flex items-center space-x-4">
            <div class="hidden md:block text-right">
              <div class="text-sm font-semibold text-slate-700">
                {{ $page.props.auth.user.name }}
              </div>
              <div class="text-xs text-slate-500 capitalize">
                {{
                  $page.props.auth.user.role === "admin"
                    ? "Administrator"
                    : "Guru"
                }}
              </div>
            </div>

            <!-- User Avatar -->
            <div
              class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold shadow-lg"
            >
              {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
            </div>

            <!-- Logout Button -->
            <form @submit.prevent="logout" class="inline">
              <button
                type="submit"
                class="flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white text-sm font-medium rounded-xl hover:from-red-600 hover:to-pink-600 transform hover:scale-105 transition-all duration-300 shadow-lg"
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
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                  />
                </svg>
                Logout
              </button>
            </form>

            <!-- Mobile Menu Button -->
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="md:hidden p-2 rounded-lg text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-colors"
            >
              <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  v-if="!mobileMenuOpen"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  v-else
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile menu -->
        <div
          v-show="mobileMenuOpen"
          class="md:hidden py-4 border-t border-blue-100"
        >
          <div class="space-y-2">
            <Link
              v-if="$page.props.auth.user.role === 'admin'"
              href="/admin/dashboard"
              :class="[
                'flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300',
                $page.url === '/admin/dashboard'
                  ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg'
                  : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50',
              ]"
            >
              <svg
                class="w-4 h-4 mr-3"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"
                />
              </svg>
              Dashboard
            </Link>

            <Link
              v-if="$page.props.auth.user.role === 'admin'"
              href="/admin/gurus"
              :class="[
                'flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300',
                $page.url === '/admin/gurus'
                  ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg'
                  : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50',
              ]"
            >
              <svg
                class="w-4 h-4 mr-3"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"
                />
              </svg>
              Data Guru
            </Link>

            <Link
              href="/presensi"
              :class="[
                'flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300',
                $page.url === '/presensi'
                  ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg'
                  : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50',
              ]"
            >
              <svg
                class="w-4 h-4 mr-3"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                />
              </svg>
              {{
                $page.props.auth.user.role === "admin"
                  ? "Data Presensi"
                  : "Presensi Saya"
              }}
            </Link>

            <Link
              v-if="$page.props.auth.user.role === 'admin'"
              href="/admin/pengaturan"
              :class="[
                'flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300',
                $page.url === '/admin/pengaturan'
                  ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg'
                  : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50',
              ]"
            >
              <svg
                class="w-4 h-4 mr-3"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                />
              </svg>
              Pengaturan
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Flash Messages -->
    <div
      v-if="$page.props.flash.success"
      class="fixed top-24 right-4 z-50 animate-slide-in-right"
    >
      <div
        class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center space-x-3 max-w-md"
      >
        <svg
          class="w-6 h-6 flex-shrink-0"
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
        <span class="font-medium">{{ $page.props.flash.success }}</span>
      </div>
    </div>

    <div
      v-if="$page.props.flash.error"
      class="fixed top-24 right-4 z-50 animate-slide-in-right"
    >
      <div
        class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center space-x-3 max-w-md"
      >
        <svg
          class="w-6 h-6 flex-shrink-0"
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
        <span class="font-medium">{{ $page.props.flash.error }}</span>
      </div>
    </div>

    <!-- Page Content -->
    <main class="relative">
      <slot />
    </main>

    <!-- Floating Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
      <div
        class="absolute top-1/4 left-1/4 w-72 h-72 bg-blue-200/20 rounded-full blur-3xl animate-float"
      ></div>
      <div
        class="absolute top-3/4 right-1/4 w-96 h-96 bg-cyan-200/20 rounded-full blur-3xl animate-float-delayed"
      ></div>
    </div>
  </div>
</template>

<script>
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

export default {
  components: {
    Link,
  },
  setup() {
    const logoutForm = useForm({});
    const mobileMenuOpen = ref(false);

    const logout = () => {
      logoutForm.post("/logout");
    };

    return {
      logout,
      mobileMenuOpen,
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

@keyframes slide-in-right {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
  animation: float-delayed 8s ease-in-out infinite;
}

.animate-slide-in-right {
  animation: slide-in-right 0.3s ease-out;
}
</style>
