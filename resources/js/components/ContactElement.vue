<template>
    <div
    class="contact-element"
    :style="elementStyles"
    @click.stop="selectElement"
    >
    <div class="contact-container" :style="containerStyles">
        <!-- Contact Heading -->
        <h2 class="contact-heading" :style="headingStyles" v-if="element.showHeading">
            {{ element.headingText }}
        </h2>

        <!-- Contact Description -->
        <p class="contact-description" :style="descriptionStyles" v-if="element.showDescription">
            {{ element.descriptionText }}
        </p>

        <!-- Contact Form -->
        <div class="contact-form" :style="formStyles" v-if="element.showForm">
            <div class="form-group" v-for="(field, index) in element.formFields" :key="index">
                <label :for="field.id" :style="labelStyles">{{ field.label }}</label>
                <input
                v-if="field.type === 'text' || field.type === 'email'"
                :type="field.type"
                :id="field.id"
                :placeholder="field.placeholder"
                :style="inputStyles"
                >
                <textarea
                v-else-if="field.type === 'textarea'"
                :id="field.id"
                :placeholder="field.placeholder"
                :rows="field.rows || 4"
                :style="textareaStyles"
                ></textarea>
            </div>

            <!-- Submit Button -->
            <button
            class="submit-button"
            :style="submitButtonStyles"
            v-if="element.showSubmitButton"
            >
            {{ element.submitButtonText }}
        </button>
    </div>

    <!-- Contact Info -->
    <div class="contact-info" :style="infoStyles" v-if="element.showContactInfo">
        <div class="info-item" v-for="(item, index) in element.contactItems" :key="index" :style="infoItemStyles">
            <span :style="infoIconStyles" v-if="item.icon">{{ item.icon }}</span>
            <span :style="infoTextStyles">{{ item.text }}</span>
        </div>
    </div>
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
            element: {
                showHeading: true,
                headingText: 'Contact Us',
                showDescription: true,
                descriptionText: 'Have questions? Get in touch with our team.',
                showForm: true,
                formFields: [
                { id: 'name', type: 'text', label: 'Name', placeholder: 'Your name' },
                { id: 'email', type: 'email', label: 'Email', placeholder: 'Your email' },
                { id: 'message', type: 'textarea', label: 'Message', placeholder: 'Your message', rows: 5 }
                ],
                showSubmitButton: true,
                submitButtonText: 'Send Message',
                showContactInfo: true,
                contactItems: [
                { icon: '📍', text: 'P8GQ+M32, Kathmandu 44600' },
                { icon: '📞', text: '+977 9813246534' },
                { icon: '✉️', text: 'bhuwanepali@gmail.com' }
                ],
                styles: {
                    backgroundColor: '#f5f5f5',
                    padding: '60px 20px',
                    textAlign: 'center'
                },
                containerStyles: {
                    maxWidth: '800px',
                    margin: '0 auto'
                },
                headingStyles: {
                    fontSize: '36px',
                    marginBottom: '20px',
                    color: '#333'
                },
                descriptionStyles: {
                    fontSize: '18px',
                    marginBottom: '40px',
                    color: '#666'
                },
                formStyles: {
                    marginBottom: '40px',
                    textAlign: 'left'
                },
                labelStyles: {
                    display: 'block',
                    marginBottom: '8px',
                    fontWeight: '500',
                    color: '#444'
                },
                inputStyles: {
                    width: '100%',
                    padding: '12px',
                    marginBottom: '20px',
                    border: '1px solid #ddd',
                    borderRadius: '4px',
                    fontSize: '16px'
                },
                textareaStyles: {
                    width: '100%',
                    padding: '12px',
                    marginBottom: '20px',
                    border: '1px solid #ddd',
                    borderRadius: '4px',
                    fontSize: '16px',
                    resize: 'vertical'
                },
                submitButtonStyles: {
                    backgroundColor: '#4CAF50',
                    color: 'white',
                    border: 'none',
                    padding: '12px 24px',
                    borderRadius: '4px',
                    cursor: 'pointer',
                    fontWeight: 'bold',
                    fontSize: '16px',
                    transition: 'background-color 0.3s',
                    '&:hover': {
                        backgroundColor: '#45a049'
                    }
                },
                infoStyles: {
                    display: 'flex',
                    flexWrap: 'wrap',
                    justifyContent: 'center',
                    gap: '30px'
                },
                infoItemStyles: {
                    display: 'flex',
                    alignItems: 'center',
                    gap: '10px'
                },
                infoIconStyles: {
                    fontSize: '20px'
                },
                infoTextStyles: {
                    fontSize: '16px',
                    color: '#555'
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
                width: "100%",
                height: "auto",
                cursor: this.isSelected ? 'move' : 'pointer',
                outline: this.isSelected ? '2px dashed #4CAF50' : 'none',
                padding: "5px",
                backgroundColor: "transparent",
                ...this.element.styles,
            };
        },
        containerStyles() {
            return this.element.containerStyles;
        },
        headingStyles() {
            return this.element.headingStyles;
        },
        descriptionStyles() {
            return this.element.descriptionStyles;
        },
        formStyles() {
            return this.element.formStyles;
        },
        labelStyles() {
            return this.element.labelStyles;
        },
        inputStyles() {
            return this.element.inputStyles;
        },
        textareaStyles() {
            return this.element.textareaStyles;
        },
        submitButtonStyles() {
            return this.element.submitButtonStyles;
        },
        infoStyles() {
            return this.element.infoStyles;
        },
        infoItemStyles() {
            return this.element.infoItemStyles;
        },
        infoIconStyles() {
            return this.element.infoIconStyles;
        },
        infoTextStyles() {
            return this.element.infoTextStyles;
        }
    },
    methods: {
        selectElement() {
            this.$emit('selected');
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
.container {
    max-width: 1200px;
    margin: 0 auto;
}
.contact-element {
    font-family: 'Arial', sans-serif;
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

.submit-button:hover {
    background-color: #45a049 !important;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
}
</style>
