<template>
    <div
    class="card-element"
    :style="elementStyles"
    @click.stop="selectElement"
    >
    <div class="card-body" :style="bodyStyles">
        <div
        v-if="!isEditing"
        class="editable-text"
        @dblclick="startEditing"
        v-html="formattedContent"
        ></div>
        <textarea
        v-else
        ref="editor"
        v-model="element.content"
        @blur="stopEditing"
        @keydown.enter.stop="stopEditing"
        :style="textStyles"
        />
    </div>
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
            element: {
                content: 'Double-click to edit this card text. You can add multiple paragraphs.',
                styles: {
                    width: '1000px',
                    backgroundColor: '#ffffff',
                    border: '1px solid #ddd',
                    borderRadius: '8px',
                    textAlign: 'center',
                    boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
                },
                bodyStyles: {
                    padding: '16px'
                },
                textStyles: {
                    width: '100%',
                    minHeight: '100px',
                    border: 'none',
                    outline: 'none',
                    resize: 'none',
                    fontFamily: 'inherit',
                    fontSize: 'inherit',
                    lineHeight: '1.5',
                },
                ...this.elementData
            }
        }
    },
    computed: {
        elementStyles() {
            return {
                position: 'absolute',
                left: `${this.element.position?.x || 0}px`,
                top: `${this.element.position?.y || 0}px`,
                cursor: this.isSelected ? 'move' : 'pointer',
                outline: this.isSelected ? '2px dashed #4CAF50' : 'none',
                ...this.element.styles
            }
        },
        bodyStyles() {
            return this.element.bodyStyles
        },
        textStyles() {
            return this.element.textStyles
        },
        formattedContent() {
            return this.element.content.replace(/\n/g, '<br>')
        }
    },
    methods: {
        selectElement() {
            this.$emit('selected')
        },
        startEditing() {
            if (this.isSelected) {
                this.isEditing = true
                this.$nextTick(() => {
                    this.$refs.editor.focus()
                })
            }
        },
        stopEditing() {
            this.isEditing = false
            this.$emit('update', this.element)
        }
    },
    watch: {
        elementData(newVal) {
            this.element = { ...this.element, ...newVal }
        }
    }
}
</script>

<style scoped>
.card-element {
    transition: all 0.2s ease;
}

.card-body {
    min-height: 50px;
}

.editable-text {
    cursor: text;
}

.editable-text:hover {
    background-color: rgba(0,0,0,0.03);
}

textarea {
    background: transparent;
    padding: 0;
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
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}
</style>
