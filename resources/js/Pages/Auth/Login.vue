<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Sistem Presensi Guru
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Silakan masuk dengan akun Anda
        </p>
      </div>
      <form @submit.prevent="login" class="mt-8 space-y-6">
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
              Email
            </label>
            <input
              v-model="form.email"
              type="email"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              :class="{ 'border-red-500': errors.email }"
            />
            <div v-if="errors.email" class="text-red-500 text-sm mt-1">
              {{ errors.email }}
            </div>
          </div>

          <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">
              Password
            </label>
            <input
              v-model="form.password"
              type="password"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              :class="{ 'border-red-500': errors.password }"
            />
            <div v-if="errors.password" class="text-red-500 text-sm mt-1">
              {{ errors.password }}
            </div>
          </div>

          <button
            type="submit"
            :disabled="processing"
            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50"
          >
            {{ processing ? "Masuk..." : "Masuk" }}
          </button>
        </div>
      </form>

      <div class="text-center text-sm text-gray-600">
        <p>Demo Akun:</p>
        <p>Admin: admin@sekolah.com / password</p>
        <p>Guru: budi@sekolah.com / password</p>
      </div>
    </div>
  </div>
</template>

<script>
import { useForm } from "@inertiajs/vue3";

export default {
  props: {
    errors: {
      type: Object,
      default: () => ({}),
    },
  },
  setup() {
    const form = useForm({
      email: "",
      password: "",
    });

    const login = () => {
      form.post("/login");
    };

    return {
      form,
      login,
      processing: form.processing,
    };
  },
};
</script>
