<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

// Sample data structure - replace with your actual data fetching
const props = defineProps({
    roles: {
        type: Array,
    },
    permissions: {
        type: Array,
    },
    rolePermissions: {
        type: Object,
    }
});

const form = useForm({
    selectedRole: props.roles[0]?.id || null,
    permissions: {}
});

// Computed properties
const currentRolePermissions = computed(() => {
    return form.selectedRole ? props.rolePermissions[form.selectedRole] || [] : [];
});

const isPermissionChecked = (permissionId) => {
    return currentRolePermissions.value.includes(permissionId);
};

// Methods
const updatePermission = (permissionId, checked) => {
    if (checked) {
        if (!currentRolePermissions.value.includes(permissionId)) {
            form.permissions = {
                ...form.permissions,
                [permissionId]: true
            };
        }
    } else {
        if (currentRolePermissions.value.includes(permissionId)) {
            form.permissions = {
                ...form.permissions,
                [permissionId]: false
            };
        }
    }
};

const submit = () => {
    form.put('/super_admin/role_permission_update', {
        selectedRole: form.selectedRole,
        permissions: form.permissions
    }, {
        preserveScroll: true,
        onSuccess: () => {
            // Show success notification
            toast.success('Permissions updated successfully!', {
                position: 'top-right',
                timeout: 1000
            });

            // You might want to refresh the rolePermissions data
            // router.reload({ only: ['rolePermissions'] });
        },
        onError: (errors) => {
            // Show error notification
            toast.error('Failed to update permissions', {
                position: 'top-right',
                timeout: 3000
            });

            // Handle specific errors if needed
            if (errors.selectedRole) {
                console.error('Role error:', errors.selectedRole);
            }
        }
    });
};
</script>

<template>
    <Head title="Role Permissions" />

    <div class="py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                        Role Permissions Management
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Role Selection -->
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium mb-2">Roles</h3>
                            <div class="space-y-2">
                                <div
                                    v-for="role in roles"
                                    :key="role.id"
                                    @click="form.selectedRole = role.id"
                                    :class="[
                                        'p-3 rounded-lg cursor-pointer transition-colors',
                                        form.selectedRole === role.id
                                            ? 'bg-indigo-100 dark:bg-indigo-900'
                                            : 'hover:bg-gray-100 dark:hover:bg-gray-700'
                                    ]"
                                >
                                    <div class="font-medium">{{ role.name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ role.description }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="md:col-span-3">
                            <div v-if="form.selectedRole" class="space-y-6">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-medium">
                                        Permissions for {{ roles.find(r => r.id === form.selectedRole)?.name }}
                                    </h3>
                                    <button
                                        @click="submit"
                                        :disabled="form.processing"
                                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md disabled:opacity-50"
                                    >
                                        Save Changes
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <div
                                        v-for="permission in permissions"
                                        :key="permission.id"
                                        class="flex items-start"
                                    >
                                        <div class="flex items-center h-5">
                                            <input
                                                :id="`permission-${permission.id}`"
                                                :name="`permission-${permission.id}`"
                                                type="checkbox"
                                                :checked="isPermissionChecked(permission.id)"
                                                @change="updatePermission(permission.id, $event.target.checked)"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                            />
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label
                                                :for="`permission-${permission.id}`"
                                                class="font-medium text-gray-700 dark:text-gray-300"
                                            >
                                                {{ permission.name }}
                                            </label>
                                            <p class="text-gray-500 dark:text-gray-400">
                                                {{ permission.description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else class="flex items-center justify-center h-64">
                                <p class="text-gray-500 dark:text-gray-400">
                                    Select a role to manage permissions
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

