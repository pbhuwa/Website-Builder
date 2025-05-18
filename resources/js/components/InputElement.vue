<template>
    <div
      class="input-element"
      :style="elementStyles"
      @click.stop="selectElement"
    >
      <label v-if="element.label" :style="labelStyles">{{ element.label }}</label>
      <input
        :type="element.inputType"
        :placeholder="element.placeholder"
        :style="inputStyles"
        @dblclick.stop="startEditing"
      />
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
        element: {
          label: 'Input Label',
          inputType: 'text',
          placeholder: 'Enter text...',
          styles: {
            width: '200px',
            padding: '8px',
            borderRadius: '4px',
            border: '1px solid #ddd'
          },
          labelStyles: {
            color: '#333',
            marginBottom: '5px',
            display: 'block'
          },
          ...this.elementData
        }
      };
    },
    computed: {
      elementStyles() {
        return {
          position: 'absolute',
          left: `${this.element.position.x}px`,
          top: `${this.element.position.y}px`,
          cursor: this.isSelected ? 'move' : 'pointer',
          outline: this.isSelected ? '2px dashed #4CAF50' : 'none',
          padding: '10px'
        };
      },
      inputStyles() {
        return this.element.styles;
      },
      labelStyles() {
        return this.element.labelStyles;
      }
    },
    methods: {
      selectElement() {
        this.$emit('selected');
      },
      startEditing() {
        if (this.isSelected) {
          this.$emit('edit-properties');
        }
      }
    },
    watch: {
      elementData(newVal) {
        this.element = { ...this.element, ...newVal };
      }
    }
  };
  </script>

  <style scoped>
  .input-element {
    display: flex;
    flex-direction: column;
  }

  input {
    font-family: inherit;
    font-size: inherit;
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
  }
  </style>
