<template>
    <footer class="footer-element" :style="footerStyles" @click.stop="selectElement">
        <div class="footer-content">
            {{ element.text || 'Footer Content' }}
        </div>

        <!-- Delete button (visible when selected) -->
        <div v-if="isSelected" class="element-controls">
            <button @click.stop="$emit('delete')">×</button>
        </div>
    </footer>
</template>

<script>
export default {
    props: {
        elementData: Object,
        isSelected: Boolean,
    },
    data() {
        return {
            element: {
                text: '© 2023 My Website. All rights reserved.',
                styles: {
                    position: 'absolute',
                    bottom: '0',
                    left: '0',
                    width: '1000px',
                    backgroundColor: '#2d3748',
                    color: 'white',
                    padding: '20px',
                    textAlign: 'center',
                },
                ...this.elementData,
            },
        };
    },
    computed: {
        footerStyles() {
            return {
                position: 'absolute',
                left: `${this.element.position?.x || 0}px`,
                top: `${this.element.position?.y || 0}px`,
                cursor: this.isSelected ? 'move' : 'pointer',
                outline: this.isSelected ? '2px dashed #4CAF50' : 'none',
                ...this.element.styles,
            };
        },
    },
    methods: {
        selectElement() {
            this.$emit('selected');
        },
    },
    watch: {
        elementData(newVal) {
            this.element = { ...this.element, ...newVal };
        },
    },
};
</script>

<style scoped>
.footer-element {
    font-family: Arial, sans-serif;
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
