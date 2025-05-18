<template>
    <div
    class="homepage-element"
    :style="elementStyles"
    @click.stop="selectElement"
    >
    <!-- Background Image -->
    <div
    class="background-image"
    :style="backgroundImageStyles"
    ></div>

    <!-- Content Container -->
    <div class="content-container" :style="contentStyles">
        <slot></slot>
    </div>

    <!-- Element Controls -->
    <div v-if="isSelected" class="element-controls">
        <button @click.stop="$emit('delete')">×</button>
        <button @click.stop="openImagePicker">🖼️</button>
        <input
        type="file"
        ref="imageInput"
        @change="handleImageUpload"
        style="display: none"
        accept="image/*"
        >
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
                backgroundImage: '/default-bg.jpg',
                backgroundStyles: {
                    size: 'cover',
                    position: 'center',
                    repeat: 'no-repeat',
                    opacity: 1
                },
                contentStyles: {
                    padding: '80px 20px',
                    maxWidth: '1200px',
                    margin: '0 auto'
                },
                styles: {
                    minHeight: '100vh',
                    position: 'relative'
                },
                ...this.elementData
            }
        };
    },
    computed: {
        elementStyles() {
            return {
                ...this.element.styles,
                cursor: this.isSelected ? 'move' : 'pointer',
                outline: this.isSelected ? '2px dashed #4CAF50' : 'none',
                left: `${this.element.position.x}px`,
                top: `${this.element.position.y}px`,
                minHeight: '100vh',
                position: 'relative'
            };
        },
        backgroundImageStyles() {
            return {
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                minHeight: '100vh', // Set minimum height to viewport height
                backgroundImage: `url(${this.element.backgroundImage})`,
                //   backgroundSize: this.element.backgroundStyles.size,
                backgroundSize: '1000px 100vh',
                backgroundPosition: this.element.backgroundStyles.position,
                backgroundRepeat: this.element.backgroundStyles.repeat,
                opacity: this.element.backgroundStyles.opacity,
                zIndex: 0
            };
        },
        contentStyles() {
            return {
                ...this.element.contentStyles,
                position: 'relative',
                zIndex: 1,
                minHeight: '100vh' // Ensure content container also spans full height
            };
        }
    },
    methods: {
        selectElement() {
            this.$emit('selected');
        },
        openImagePicker() {
            this.$refs.imageInput.click();
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

                this.element.backgroundImage = response.data.url;
                this.$emit('update', this.element);
            } catch (error) {
                console.error('Image upload failed:', error);
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
.homepage-element {
    transition: all 0.2s ease;
}

.background-image {
    transition: all 0.3s ease;
}

.content-container {
    transition: all 0.3s ease;
}

.element-controls {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    gap: 5px;
    z-index: 10;
}

.element-controls button {
    background: rgba(0,0,0,0.7);
    color: white;
    border: none;
    border-radius: 4px;
    width: 30px;
    height: 30px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.element-controls button:hover {
    background: rgba(0,0,0,0.9);
}
</style>
