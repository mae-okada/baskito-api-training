<template>
  <Link :class="buttonClass" :href="href" :disabled="props.disabled">
    <slot></slot>
  </Link>
</template>

<script setup lang="ts">
import type {
  ButtonSize,
  ButtonVariants,
  ButtonShape
} from "@/scripts/types/ui";
import { useBaseButton } from "@/scripts/composables/ui/button/useBaseButton";
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const { getClassVariant, getClassSize, getClassShape } = useBaseButton();

const props = withDefaults(
  defineProps<{
    href: string;
    variant?: ButtonVariants;
    block?: boolean;
    size?: ButtonSize;
    shape?: ButtonShape;
    disabled?: boolean;
    progress?: boolean;
  }>(),
  {
    variant: "primary",
    block: false,
    size: "md",
    shape: "default",
    disabled: false,
    progress: false
  }
);

const buttonClass = computed(() => [
  {
    btn: true,
    disabled: props.disabled,
    "btn-block": props.block,
    "btn-progress": props.progress
  },
  getClassVariant(props.variant),
  getClassSize(props.size),
  getClassShape(props.shape)
]);
</script>
