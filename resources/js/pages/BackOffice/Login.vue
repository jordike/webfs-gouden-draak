<script lang="ts" setup>
    import { defineProps } from 'vue';

    defineProps<{
        csrf: string;
    }>();
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <form class="max-w-sm rounded-lg bg-white p-8 shadow-md" method="POST" action="/login">
            <input type="hidden" name="_token" :value="csrf" />

            <div
                v-if="$page.props.errors && Object.keys($page.props.errors).length"
                class="mb-4 w-full max-w-sm rounded bg-red-100 p-4 text-red-700 shadow"
            >
                <ul>
                    <li v-for="(error, key) in $page.props.errors" :key="key">{{ error }}</li>
                </ul>
            </div>

            <div class="mb-4 flex justify-center">
                <img src="/assets/img/dragon-large.png" alt="Logo" class="h-16 w-auto" />
            </div>

            <h2 class="mb-6 text-center text-2xl font-bold text-gray-800">Login</h2>

            <div class="mb-4">
                <label class="mb-2 block text-gray-700" for="email">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                    placeholder="Enter your email"
                    required
                />
            </div>

            <div class="mb-6">
                <label class="mb-2 block text-gray-700" for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                    placeholder="Enter your password"
                    required
                />
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 py-2 font-semibold text-white shadow-md transition-colors hover:from-yellow-500 hover:to-yellow-700"
            >
                Login
            </button>
        </form>
    </div>
</template>
