<template>
    <div class="text-block" :style="elementStyles" @click.stop="selectElement">
        <div v-if="!isEditing" v-html="formattedContent"></div>
        <textarea v-else ref="editor" v-model="element.content" :style="elementStyles" />
        <div v-if="isSelected" class="element-controls">
            <button @click.stop="$emit('delete')">×</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        elementData: Object,
        isSelected: Boolean,
    },
    data() {
        return {
            isEditing: false,
            element: { ...this.elementData },
        };
    },
    computed: {
        elementStyles() {
            return {
                position: 'absolute',
                left: `${this.element.position.x}px`,
                top: `${this.element.position.y}px`,
                width: 'auto',
                height: 'auto',
                cursor: this.isSelected ? 'move' : 'pointer',
                outline: this.isSelected ? '2px dashed #4CAF50' : 'none',
                padding: '5px',
                backgroundColor: 'transparent',
                ...this.element.styles,
            };
        },
        formattedContent() {
            return this.element.content.replace(/\n/g, '<br>');
        },
    },
    methods: {
        selectElement() {
            this.$emit('selected');
        },
    },
    watch: {
        elementData(newVal) {
            this.element = { ...newVal };
        },
    },
};
</script>

<style scoped>
.text-block {
    min-width: 100px;
    min-height: 20px;
    padding: 5px;
    transition: outline 0.1s ease;
}

textarea {
    border: none;
    resize: none;
    overflow: hidden;
    background: transparent;
    width: auto;
    height: auto;
    font-family: inherit;
    font-size: inherit;
    color: inherit;
    padding: 5px;
    box-sizing: border-box;
    position: absolute;
    left: 0;
    top: 0;
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
