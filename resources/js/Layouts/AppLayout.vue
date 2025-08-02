<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <h1 class="text-xl font-bold text-gray-900">
                Sistem Presensi Guru
              </h1>
            </div>
            <div class="hidden md:ml-6 md:flex md:space-x-8">
              <Link
                v-if="$page.props.auth.user.role === 'admin'"
                href="/admin/dashboard"
                :class="[
                  'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium',
                  $page.url === '/admin/dashboard'
                    ? 'border-blue-500 text-gray-900'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                ]"
              >
                Dashboard
              </Link>

              <Link
                v-if="$page.props.auth.user.role === 'admin'"
                href="/admin/gurus"
                :class="[
                  'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium',
                  $page.url === '/admin/gurus'
                    ? 'border-blue-500 text-gray-900'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                ]"
              >
                Data Guru
              </Link>

              <Link
                href="/presensi"
                :class="[
                  'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium',
                  $page.url === '/presensi'
                    ? 'border-blue-500 text-gray-900'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                ]"
              >
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
                  'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium',
                  $page.url === '/admin/pengaturan'
                    ? 'border-blue-500 text-gray-900'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                ]"
              >
                Pengaturan
              </Link>
            </div>
          </div>

          <div class="flex items-center space-x-4">
            <div class="text-sm text-gray-700">
              <span class="font-medium">{{ $page.props.auth.user.name }}</span>
              <span class="text-gray-500"
                >({{
                  $page.props.auth.user.role === "admin" ? "Admin" : "Guru"
                }})</span
              >
            </div>

            <form @submit.prevent="logout" class="inline">
              <button
                type="submit"
                class="bg-red-500 hover:bg-red-700 text-white text-sm px-3 py-1 rounded"
              >
                Logout
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div class="md:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <Link
            v-if="$page.props.auth.user.role === 'admin'"
            href="/admin/dashboard"
            :class="[
              'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
              $page.url === '/admin/dashboard'
                ? 'bg-blue-50 border-blue-500 text-blue-700'
                : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300',
            ]"
          >
            Dashboard
          </Link>

          <Link
            v-if="$page.props.auth.user.role === 'admin'"
            href="/admin/gurus"
            :class="[
              'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
              $page.url === '/admin/gurus'
                ? 'bg-blue-50 border-blue-500 text-blue-700'
                : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300',
            ]"
          >
            Data Guru
          </Link>

          <Link
            href="/presensi"
            :class="[
              'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
              $page.url === '/presensi'
                ? 'bg-blue-50 border-blue-500 text-blue-700'
                : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300',
            ]"
          >
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
              'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
              $page.url === '/admin/pengaturan'
                ? 'bg-blue-50 border-blue-500 text-blue-700'
                : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300',
            ]"
          >
            Pengaturan
          </Link>
        </div>
      </div>
    </nav>

    <!-- Flash Messages -->
    <div
      v-if="$page.props.flash.success"
      class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 relative"
    >
      <span class="block sm:inline">{{ $page.props.flash.success }}</span>
    </div>

    <div
      v-if="$page.props.flash.error"
      class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 relative"
    >
      <span class="block sm:inline">{{ $page.props.flash.error }}</span>
    </div>

    <!-- Page Content -->
    <main>
      <slot />
    </main>
  </div>
</template>

<script>
import { Link, useForm } from "@inertiajs/vue3";

export default {
  components: {
    Link,
  },
  setup() {
    const logoutForm = useForm({});

    const logout = () => {
      logoutForm.post("/logout");
    };

    return {
      logout,
    };
  },
};
</script>
