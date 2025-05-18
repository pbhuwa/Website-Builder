<template>
    <div
      class="button-element"
      :style="elementStyles"
      @click.stop="selectElement"
    >
      <button
        :style="buttonStyles"
        @dblclick.stop="startEditing"
      >
        <span v-if="!isEditing">{{ element.text }}</span>
        <input
          v-else
          ref="editor"
          v-model="element.text"
          @blur="stopEditing"
          @keydown.enter="stopEditing"
        />
      </button>
      <div v-if="isSelected" class="element-controls">
        <button @click.stop="$emit('delete')">×</button>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      elementData: Object,
      isSelected: Boolean
    },
    data() {
      return {
        isEditing: false,
        element: { ...this.elementData }
      };
    },
    computed: {
      elementStyles() {
        return {
          position: 'absolute',
          left: `${this.element.position.x}px`,
          top: `${this.element.position.y}px`,
          cursor: this.isSelected ? 'move' : 'pointer',
          outline: 'none'
        };
      },
      buttonStyles() {
        return {
          cursor: 'pointer',
          outline: this.isSelected ? '2px dashed #4CAF50' : 'none',
          ...this.element.styles
        };
      }
    },
    methods: {
      selectElement() {
        this.$emit('selected');
      },
      startEditing() {
        if (this.isSelected) {
          this.isEditing = true;
          this.$nextTick(() => {
            this.$refs.editor.focus();
          });
        }
      },
      stopEditing() {
        this.isEditing = false;
        this.$emit('update', this.element);
      }
    },
    watch: {
      elementData(newVal) {
        this.element = { ...newVal };
      }
    }
  };
  </script>

  <style scoped>
  .button-element {
    display: inline-block;
  }

  button {
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    transition: all 0.3s;
  }

  input {
    width: 100%;
    height: 100%;
    border: none;
    background: transparent;
    color: inherit;
    font-size: inherit;
    text-align: center;
  }

  .element-controls {
    position: absolute;
    top: -15px;
    right: -15px;
  }

  .element-controls button {
    background: #ff4444;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    font-size: 14px;
    margin: 0;
    padding: 0;
  }
  </style>
