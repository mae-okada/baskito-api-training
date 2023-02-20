<template>
  <button :class="buttonClass" :disabled="disabled || loading">
    <div v-if="loading">
      <span
        class="spinner-border spinner-border-sm"
        role="status"
        aria-hidden="true"
      ></span>
      {{ loadingText }}
    </div>
    <slot v-else></slot>
  </button>
</template>

<script setup lang="ts">
import type {
  ButtonSize,
  ButtonVariants,
  ButtonShape,
} from "@/scripts/types/ui";
import { useBaseButton } from "@/scripts/composables/ui/button/useBaseButton";
import { computed } from "vue";

const { getClassVariant, getClassSize, getClassShape } = useBaseButton();

const props = withDefaults(
  defineProps<{
    variant?: ButtonVariants;
    block?: boolean;
    size?: ButtonSize;
    shape?: ButtonShape;
    disabled?: boolean;
    progress?: boolean;
    loading?: boolean;
    loadingText?: string;
  }>(),
  {
    variant: "primary",
    block: false,
    size: "md",
    shape: "default",
    disabled: false,
    progress: false,
    loading: false,
    loadingText: "Loading...",
  }
);

const buttonClass = computed(() => [
  {
    btn: true,
    disabled: props.disabled || props.loading,
    "btn-block": props.block,
    "btn-progress": props.progress,
  },
  getClassVariant(props.variant),
  getClassSize(props.size),
  getClassShape(props.shape),
]);
</script>
