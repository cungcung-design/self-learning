<template>
  <div
    v-if="open"
    class="absolute w-full bg-black bg-opacity-30 h-screen top-0 left-0 flex justify-center px-8"
    @click.self="handleClose"
    role="dialog"
    aria-modal="true"
  >
    <div class="p-4 bg-white self-start mt-32 max-w-screen-md">
      <div class="flex items-start justify-between gap-4">
        <slot>
          <button
            class="text-white mt-8 bg-weather-secondary px-3 py-2 rounded"
          >
            OK
          </button>
        </slot>
        <button
          type="button"
          class="text-weather-secondary hover:text-weather-secondary/80"
          aria-label="Close modal"
          @click="handleClose"
        >
          ✕
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  open: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["close"]);

function handleClose() {
  emit("close");
}
</script>

<style lang="scss" scoped></style>
