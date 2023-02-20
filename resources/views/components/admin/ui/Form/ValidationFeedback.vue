<template>
  <div v-if="!!message" class="invalid-feedback">
    {{ message }}
  </div>
</template>

<script setup lang="ts">
defineProps<{
  message?: string;
}>();
</script>
