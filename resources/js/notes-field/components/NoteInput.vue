<template>
  <div>
    <div class="mb-4">
      <label for="type" class="block text-80 pt-2 leading-tight mb-2">Type</label>
      <select
        name="type"
        class="form-control form-input form-input-bordered py-3 h-auto"
        v-model="type"
      >
        <option v-for="(label, typeValue) in types" v-bind:value="typeValue">
          {{ label }}
        </option>
      </select>
    </div>
    <div class="mb-4" :class="fullWidth ? 'w-full' : 'w-3/5'">
      <div v-if="trixEnabled">
        <trix-editor
          ref="trixEditor"
          @keydown.stop
          @trix-change="note = $refs.trixEditor.value"
          @trix-initialize="initialize"
          :value="note"
          :placeholder="placeholder"
          class="trix-content w-full form-control form-input form-input-bordered py-3 h-auto"
        />
      </div>

      <textarea
        v-else
        rows="3"
        :placeholder="placeholder"
        class="form-control w-full form-input form-input-bordered py-3 h-auto"
        v-model="note"
        v-on:input="$emit('input', $event.target.value)"
        v-on:keydown.enter="onEnter"
      />

      <div class="whitespace-no-wrap mt-4">
        <button
          class="btn btn-default btn-primary inline-flex items-center relative ml-auto"
          @click="submit()"
          type="button"
          :disabled="loading || !note"
        >
          {{ __('novaNotesField.addNote') }}
        </button>
      </div>
    </div>
  </div>

</template>

<script>
export default {
  props: ['placeholder', 'type', 'note', 'types', 'loading', 'trixEnabled', 'fullWidth'],
  mounted () {
    this.type = Object.keys(this.types)[0];
  },
  methods: {
    initialize() {
      this.$refs.trixEditor.editor.loadHTML(this.note);
    },

    submit() {
      this.$emit('onSubmit', {'note': this.note, 'type': this.type});
    },
  },

  watch: {
    value(newValue, oldValue) {
      if (this.trixEnabled && this.$refs.trixEditor) {
        if (!newValue && !!oldValue) this.$refs.trixEditor.editor.loadHTML('');
      }
    },
  },
};
</script>
