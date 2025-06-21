<template>
  <div :class="['relative z-0 w-full group', $attrs.class]">
    <input
      :id="id"
      :name="id"
      type="text"
      :placeholder="placeholder"
      :required="required"
      v-bind="$attrs"
      v-model="modelValue"
      class="peer block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600"
    />
    <label
      :for="id"
      class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:scale-75 peer-focus:-translate-y-6"
    >
      {{ label }}
    </label>
    <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
  </div>
</template>

<script setup>
defineProps({
  id: String,
  label: String,
  error: String,
  modelValue: [String, Number],
  required: Boolean,
  placeholder: {
    type: String,
    default: ' '
  }
})
defineEmits(['update:modelValue'])
</script>
