<template>
    <div class="builder-container">
        <!-- Component Library Sidebar -->
        <div class="component-library">
            <h5 class="mb-2 text-xs font-semibold">Components</h5>
            <div
                v-for="component in componentTypes"
                :key="component.type"
                class="component-item"
                draggable="true"
                @dragstart="startDrag($event, component)"
            >
                <div class="text-gray-500" :title="component.label">
                    {{ component.label }}
                </div>
            </div>
        </div>

        <!-- Main Canvas Area -->
        <div class="canvas-area" ref="canvas" @drop="handleDrop($event)" @dragover.prevent @click="clearSelection">
            <div class="mb-1 flex items-center space-x-2 p-2">
                <input
                    v-model="websiteName"
                    placeholder="Website name"
                    value="websiteName"
                    required
                    :class="{
                        'rounded border border-gray-300 px-3 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none': true,
                        'rounded border border-red-500 px-3 py-1 focus:ring-2 focus:ring-red-500 focus:outline-none': hasError,
                    }"
                />

                <button
                    class="rounded bg-blue-500 px-4 py-1 font-semibold text-white shadow hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    @click="saveToWebsite"
                >
                    Save
                </button>

                <button
                    v-if="websiteId"
                    class="rounded bg-green-500 px-4 py-1 font-semibold text-white shadow hover:bg-green-600 focus:ring-2 focus:ring-green-500 focus:outline-none"
                    @click="publishWebsite"
                >
                    Publish
                </button>

                <a
                    :href="publishedUrl"
                    target="_blank"
                    v-if="publishedUrl"
                    class="rounded bg-gray-500 px-4 py-1 font-semibold text-white shadow hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:outline-none"
                >
                    View Site
                </a>
            </div>

            <div class="canvas" :style="canvasStyle">
                <component
                    v-for="(element, index) in elements"
                    :key="element.id"
                    :is="getComponentName(element.type)"
                    :elementData="element"
                    :isSelected="activeElementIndex === index"
                    @selected="setActiveElement(index)"
                    @update="updateElement(index, $event)"
                    @delete="deleteElement(index)"
                />
            </div>
        </div>

        <!-- Properties Panel -->
        <div class="properties-panel" v-if="activeElement">
            <h3>Properties</h3>
            <ElementProperties :element="activeElement" @update="updateActiveElement($event)" />
        </div>
    </div>
</template>

<script>
import AboutUsElement from './AboutUsElement.vue';
import ButtonElement from './ButtonElement.vue';
import CardElement from './CardElement.vue';
import ContactElement from './ContactElement.vue';
import ElementProperties from './ElementProperties.vue';
import FooterElement from './FooterElement.vue';
import HeaderElement from './HeaderElement.vue';
import HomeElement from './HomeElement.vue';
import ImageElement from './ImageElement.vue';
import InputElement from './InputElement.vue';
import ServicesElement from './ServicesElement.vue';
import TextBlock from './TextBlock.vue';

export default {
    components: {
        HeaderElement,
        HomeElement,
        ServicesElement,
        AboutUsElement,
        ContactElement,
        FooterElement,
        TextBlock,
        ImageElement,
        ButtonElement,
        InputElement,
        CardElement,
        ElementProperties,
    },
    data() {
        return {
            websiteName: '',
            hasError: false,
            websiteId: null,
            publishedUrl: '',
            elements: [],
            activeElementIndex: null,
            componentTypes: [
                { type: 'header', label: 'Header' },
                { type: 'homepage', label: 'Home' },
                { type: 'services', label: 'Services' },
                { type: 'about-us', label: 'About Us' },
                { type: 'contact', label: 'Contact' },
                { type: 'footer', label: 'Footer' },
                { type: 'text-block', label: 'Text' },
                { type: 'image', label: 'Image' },
                { type: 'button', label: 'Button' },
                { type: 'input', label: 'Input' },
                { type: 'card', label: 'Card' },
            ],
            canvasDimensions: {
                width: 1000,
                height: 2650,
                background: '#ffffff',
            },
            draggedComponent: null,
        };
    },
    computed: {
        activeElement() {
            return this.activeElementIndex !== null ? this.elements[this.activeElementIndex] : null;
        },
        canvasStyle() {
            return {
                width: `${this.canvasDimensions.width}px`,
                height: `${this.canvasDimensions.height}px`,
                backgroundColor: this.canvasDimensions.background,
                position: 'relative',
            };
        },
    },
    methods: {
        getComponentName(type) {
            return type === 'header'
                ? 'HeaderElement'
                : type === 'homepage'
                  ? 'HomeElement'
                  : type === 'services'
                    ? 'ServicesElement'
                    : type === 'about-us'
                      ? 'AboutUsElement'
                      : type === 'contact'
                        ? 'ContactElement'
                        : type === 'footer'
                          ? 'FooterElement'
                          : type === 'text-block'
                            ? 'TextBlock'
                            : type === 'image'
                              ? 'ImageElement'
                              : type === 'button'
                                ? 'ButtonElement'
                                : type === 'input'
                                  ? 'InputElement'
                                  : type === 'card'
                                    ? 'CardElement'
                                    : '';
        },
        startDrag(event, component) {
            this.draggedComponent = component;
            event.dataTransfer.setData('component-type', component.type);
            event.dataTransfer.effectAllowed = 'copy';
        },
        handleDrop(event) {
            const componentType = event.dataTransfer.getData('component-type');
            const canvasRect = this.$refs.canvas.getBoundingClientRect();

            const newElement = {
                id: this.generateId(),
                type: componentType,
                position: {
                    x: event.clientX - canvasRect.left,
                    y: event.clientY - canvasRect.top,
                },
                ...this.getDefaultProperties(componentType),
            };

            this.elements.push(newElement);
            this.saveToWebsite();
        },
        generateId() {
            return Date.now().toString(36) + Math.random().toString(36).substr(2);
        },
        getDefaultProperties(type) {
            const defaults = {
                'text-block': {
                    content: 'New Text Block',
                    styles: {
                        fontSize: '16px',
                        color: '#000000',
                        fontWeight: 'normal',
                    },
                },
                homepage: {
                    backgroundImage: '/default.jpg',
                    backgroundStyles: {
                        size: 'contain',
                        position: 'center',
                        repeat: 'no-repeat',
                        opacity: 1,
                    },
                    contentStyles: {
                        padding: '80px 20px',
                        maxWidth: '1000px',
                        margin: '0 auto',
                    },
                    styles: {
                        minHeight: '100vh',
                    },
                },
                'about-us': {
                    position: { x: 0, y: 0 }, // Default position
                    backgroundStyles: {
                        color: '#f8f9fa', // Light gray background color
                        image: '', // No image by default
                        size: 'cover',
                        position: 'center',
                        repeat: 'no-repeat',
                        opacity: 1,
                        overlayColor: 'rgba(0,0,0,0.2)', // Slight dark overlay
                    },
                    contentStyles: {
                        padding: '80px 20px',
                        maxWidth: '1200px',
                        margin: '0 auto',
                        backgroundColor: 'rgba(255,255,255,0.9)', // Slightly transparent white
                        boxShadow: '0 4px 12px rgba(0,0,0,0.1)',
                    },
                    styles: {
                        minHeight: '100vh',
                        width: '100%',
                        position: 'relative',
                    },
                    titleStyles: {
                        text: 'About Our Company',
                        fontSize: '2.5rem',
                        fontWeight: '700',
                        color: '#2c3e50',
                        textAlign: 'center',
                        marginBottom: '2rem',
                        fontFamily: '"Helvetica Neue", Arial, sans-serif',
                    },
                    sectionStyles: {
                        title: {
                            fontSize: '1.8rem',
                            fontWeight: '600',
                            color: '#34495e',
                            marginBottom: '1.5rem',
                            fontFamily: '"Helvetica Neue", Arial, sans-serif',
                        },
                        content: {
                            fontSize: '1.1rem',
                            lineHeight: '1.8',
                            color: '#4a5568',
                            marginBottom: '2.5rem',
                        },
                    },
                    mission: {
                        title: 'Our Mission',
                        content:
                            'We are dedicated to delivering exceptional value through innovative solutions and unparalleled customer service. Our team of experts works tirelessly to exceed expectations and build lasting relationships with our clients.',
                    },
                    team: {
                        show: true,
                        title: 'Meet Our Team',
                        maxMembers: 4,
                        members: [
                            {
                                name: 'Bhuwanesh Kumar',
                                position: 'CEO & Founder',
                                image: '',
                            },
                            {
                                name: 'Anil Kumar Sah',
                                position: 'Creative Director',
                                image: '',
                            },
                            {
                                name: 'Subham Prasad',
                                position: 'Creative Director',
                                image: '',
                            },
                        ],
                        styles: {
                            gridColumns: 4, // Default number of columns
                            gap: '30px',
                            cardBackground: '#ffffff',
                            cardPadding: '20px',
                            cardRadius: '8px',
                            cardShadow: '0 2px 8px rgba(0,0,0,0.1)',
                        },
                    },
                    values: {
                        show: true,
                        title: 'Our Core Values',
                        items: [
                            { title: 'Integrity', icon: '✓', description: 'We do the right thing, always' },
                            { title: 'Innovation', icon: '💡', description: 'Constantly pushing boundaries' },
                            { title: 'Excellence', icon: '⭐', description: 'Only our best is good enough' },
                        ],
                        styles: {
                            layout: 'grid', // or 'list'
                            columns: 3,
                            iconSize: '2rem',
                        },
                    },
                },
                services: {
                    position: { x: 0, y: 0 },
                    styles: {
                        width: '100%',
                        padding: '60px 20px',
                        backgroundColor: '#ffffff',
                    },
                    containerStyles: {
                        maxWidth: '1200px',
                        margin: '0 auto',
                    },
                    title: {
                        text: 'Our Services',
                        styles: {
                            fontSize: '2rem',
                            color: '#2c3e50',
                            textAlign: 'center',
                            marginBottom: '40px',
                        },
                    },
                    gridStyles: {
                        display: 'grid',
                        gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))',
                        gap: '30px',
                    },
                    cardStyles: {
                        backgroundColor: '#f8f9fa',
                        borderRadius: '8px',
                        padding: '30px',
                        transition: 'all 0.3s ease',
                    },
                    iconStyles: {
                        fontSize: '2.5rem',
                        marginBottom: '20px',
                        color: '#3498db',
                    },
                    serviceTitleStyles: {
                        fontSize: '1.3rem',
                        marginBottom: '15px',
                        color: '#34495e',
                    },
                    descriptionStyles: {
                        color: '#7f8c8d',
                        lineHeight: '1.6',
                    },
                    buttonStyles: {
                        backgroundColor: '#3498db',
                        color: 'white',
                        border: 'none',
                        padding: '10px 20px',
                        borderRadius: '4px',
                        cursor: 'pointer',
                    },
                    services: [
                        {
                            icon: '🛠️',
                            title: 'Web Development',
                            description: 'Custom websites tailored to your business needs.',
                        },
                        {
                            icon: '📱',
                            title: 'Mobile Apps',
                            description: 'iOS and Android applications for your users.',
                        },
                        {
                            icon: '🔍',
                            title: 'SEO Optimization',
                            description: 'Improve your search engine rankings.',
                        },
                    ],
                },
                image: {
                    src: '/placeholder.png',
                    alt: 'Image',
                    styles: {
                        width: '200px',
                        height: 'auto',
                    },
                },
                button: {
                    text: 'Click Me',
                    styles: {
                        backgroundColor: '#4CAF50',
                        color: 'white',
                        padding: '10px 20px',
                        borderRadius: '4px',
                    },
                },
                input: {
                    placeholder: 'Enter text...',
                    styles: {
                        backgroundColor: '#ffffff',
                        color: 'darkgray',
                        padding: '10px 20px',
                        borderRadius: '4px',
                        border: '1px solid #ddd',
                    },
                },
                card: {
                    type: 'card',
                    content: 'Your editable text here...',
                    styles: {
                        width: '300px',
                        backgroundColor: '#ffffff',
                        color: 'darkgray',
                        padding: '10px 20px',
                        borderRadius: '4px',
                        border: '1px solid #ddd',
                    },
                },
                footer: {
                    type: 'footer',
                    styles: {
                        width: '1000px',
                        backgroundColor: '#ffffff',
                        color: 'darkgray',
                        padding: '10px 20px',
                        textAlign: 'center',
                    },
                },
            };
            return defaults[type] || {};
        },
        setActiveElement(index) {
            this.activeElementIndex = index;
            event.stopPropagation();
        },
        clearSelection() {
            this.activeElementIndex = null;
        },
        updateElement(index, updatedProps) {
            this.elements[index] = { ...this.elements[index], ...updatedProps };
            this.saveToWebsite();
        },
        updateActiveElement(updatedProps) {
            console.log('Updating active element with props:', updatedProps);

            if (this.activeElementIndex !== null) {
                this.updateElement(this.activeElementIndex, updatedProps);
            }
        },
        deleteElement(index) {
            this.elements.splice(index, 1);
            if (this.activeElementIndex === index) {
                this.activeElementIndex = null;
            }
            this.saveToWebsite();
        },
        async saveToWebsite() {
            try {
                const response = await this.$api.post('/api/save-website', {
                    id: this.websiteId,
                    name: this.websiteName,
                    elements: this.elements,
                    canvas: this.canvasDimensions,
                });

                this.hasError = false;
                console.log('Saved successfully', response.data);
            } catch (error) {
                this.hasError = true;
                console.error('Error saving:', error);
            }
        },
        async loadFromBackend() {
            try {
                const response = await this.$api.get('/api/load-website');
                this.websiteId = response.data.id || null;
                this.websiteName = response.data.name || null;
                this.elements = response.data.elements || [];
                this.canvasDimensions = response.data.canvas || this.canvasDimensions;
            } catch (error) {
                console.error('Error loading:', error);
            }
        },
        async publishWebsite() {
            try {
                const response = await this.$api.post(`/api/websites/${this.websiteId}/publish`);
                this.publishedUrl = response.data.url;
            } catch (error) {
                console.error('Publish failed:', error);
            }
        },
    },
    mounted() {
        this.loadFromBackend();
    },
};
</script>

<style scoped>
.builder-container {
    display: flex;
    height: 100vh;
    overflow: hidden;
}

.component-library {
    width: 150px;
    padding: 15px;
    background: #f5f5f5;
    border-right: 1px solid #ddd;
}

.component-item {
    padding: 10px;
    margin-bottom: 8px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: grab;
}

.component-item:hover {
    background: #e9e9e9;
}

.canvas-area {
    flex: 1;
    padding: 20px;
    overflow: auto;
    background: #eee;
}

.canvas {
    margin: 0 auto;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.properties-panel {
    width: 300px;
    padding: 15px;
    background: #f5f5f5;
    border-left: 1px solid #ddd;
    overflow-y: auto;
}
</style>
