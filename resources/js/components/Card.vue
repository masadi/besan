<template>
  <div class="card">
    <div v-if="title" class="card-header d-flex justify-content-between align-items-center">
      {{ title }}
      <b-button v-if="button" variant="primary" size="sm" :to="to">{{button_text}}</b-button>
    </div>

    <div class="card-body">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: { type: String, default: null },
    button: { type: Boolean, default: false},
    button_text: { type: String, default: null },
    to: { type: String, default: null },
  }
}
</script>
