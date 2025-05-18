<template>
    <div
      class="image-element"
      :style="elementStyles"
      @click.stop="selectElement"
    >
      <img
        :src="element.src"
        :alt="element.alt"
        :style="imageStyles"
      />
      <div v-if="isSelected" class="element-controls">
        <button @click.stop="$emit('delete')">×</button>
        <input
          type="file"
          ref="fileInput"
          @change="handleImageUpload"
          style="display: none"
        />
        <button @click.stop="triggerFileInput">🖼️</button>
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
          outline: this.isSelected ? '2px dashed #4CAF50' : 'none',
          display: 'inline-block'
        };
      },
      imageStyles() {
        return {
          width: this.element.styles?.width || '100%',
          height: this.element.styles?.height || 'auto',
          display: 'block'
        };
      }
    },
    methods: {
      selectElement() {
        this.$emit('selected');
      },
      triggerFileInput() {
        this.$refs.fileInput.click();
      },
      async handleImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        try {
          const formData = new FormData();
          formData.append('image', file);

          const response = await axios.post('/api/upload-image', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });

          this.element.src = response.data.url;
          this.$emit('update', this.element);
        } catch (error) {
          console.error('Error uploading image:', error);
        }
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
  .image-element {
    transition: outline 0.1s ease;
  }

  .element-controls {
    position: absolute;
    top: -15px;
    right: -15px;
    display: flex;
    gap: 5px;
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
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .element-controls button:last-child {
    background: #4285F4;
  }
  </style>
