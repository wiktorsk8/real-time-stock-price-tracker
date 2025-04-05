<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
  name: null,
  email: null,
  password: null,
  password_confirmation: null
})

function submit() {
  router.post('/register', form)
}
</script>

<template>
  <div class="max-w-sm mx-auto p-6 bg-white rounded-lg shadow-lg">
    <form @submit.prevent="submit" class="space-y-6">
      <div>
        <label for="name" class="block text-gray-700 font-medium">Name</label>
        <input
            id="name"
            type="text"
            v-model="form.name"
            class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
            placeholder="Enter your name"
        />
      </div>

      <div>
        <label for="email" class="block text-gray-700 font-medium">Email</label>
        <input
            id="email"
            type="email"
            v-model="form.email"
            class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
            placeholder="Enter your email"
        />
      </div>

      <div>
        <label for="password" class="block text-gray-700 font-medium">Password</label>
        <input
            id="password"
            type="password"
            v-model="form.password"
            class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
            placeholder="Enter your password"
        />
      </div>

      <div>
        <label for="password_confirmation" class="block text-gray-700 font-medium">Confirm Password</label>
        <input
            id="password_confirmation"
            type="password"
            v-model="form.password_confirmation"
            class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
            placeholder="Confirm your password"
        />
      </div>

      <div>
        <button
            type="submit"
            class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Submit
        </button>
      </div>
    </form>
  </div>
</template>

