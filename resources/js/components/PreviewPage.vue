<template>
    <div class="preview-container">
        <div class="preview-canvas" :style="[canvasStyle, deviceStyles]">
            <!-- Render elements in fixed order but maintain their positions -->
            <template v-for="element in orderedElements" :key="element.id">
                <component :is="getComponentName(element.type)" :elementData="element" :isSelected="false" :style="getElementStyles(element)" />
            </template>
        </div>

        <div class="preview-controls">
            <el-button type="primary" @click="closePreview">Close Preview</el-button>
            <el-button @click="toggleDevice('desktop')" :type="device === 'desktop' ? 'primary' : ''">
                <el-icon><Monitor /></el-icon>
            </el-button>
            <el-button @click="toggleDevice('tablet')" :type="device === 'tablet' ? 'primary' : ''">
                <el-icon><Cellphone /></el-icon>
            </el-button>
            <el-button @click="toggleDevice('mobile')" :type="device === 'mobile' ? 'primary' : ''">
                <el-icon><Iphone /></el-icon>
            </el-button>
        </div>
    </div>
</template>

<script lang="ts">
import { Cellphone, Iphone, Monitor } from '@element-plus/icons-vue';
import { defineComponent } from 'vue';
import AboutUsElement from './AboutUsElement.vue';
import ContactElement from './ContactElement.vue';
import FooterElement from './FooterElement.vue';
import HeaderElement from './HeaderElement.vue';
import HomeElement from './HomeElement.vue';
import ServicesElement from './ServicesElement.vue';

export default defineComponent({
    name: 'WebsitePreview',
    components: {
        Monitor,
        Cellphone,
        Iphone,
        HeaderElement,
        HomeElement,
        ServicesElement,
        AboutUsElement,
        ContactElement,
        FooterElement,
    },

    props: {
        elements: {
            type: Array as () => any[],
            required: true,
        },
        canvasStyle: {
            type: Object,
            default: () => ({
                width: '100%',
                minHeight: '100vh',
                backgroundColor: '#ffffff',
                position: 'relative',
            }),
        },
    },

    data() {
        return {
            device: 'desktop' as 'desktop' | 'tablet' | 'mobile',
        };
    },

    computed: {
        orderedElements() {
            // Define the desired order of sections
            const sectionOrder = ['header', 'homepage', 'services', 'about-us', 'contact', 'footer'];

            // Create a map of elements by type
            const elementsByType: Record<string, any> = {};
            this.elements.forEach((el) => {
                if (el.type) {
                    elementsByType[el.type] = el;
                }
            });

            // Return elements in the desired order
            return sectionOrder.map((type) => elementsByType[type]).filter((el) => el); // Remove undefined
        },

        deviceStyles() {
            const styles: any = {
                ...this.canvasStyle,
                width: `${this.canvasStyle.width || 1000}px`,
                height: `${this.canvasStyle.height || 2650}px`,
                position: 'relative',
            };

            switch (this.device) {
                case 'tablet':
                    styles.maxWidth = '768px';
                    styles.margin = '0 auto';
                    styles.boxShadow = '0 0 20px rgba(0,0,0,0.2)';
                    break;
                case 'mobile':
                    styles.maxWidth = '375px';
                    styles.margin = '0 auto';
                    styles.boxShadow = '0 0 20px rgba(0,0,0,0.2)';
                    break;
                default:
                    // Desktop - use original styles
                    break;
            }

            return styles;
        },
    },

    methods: {
        getComponentName(type: string) {
            const componentMap: Record<string, string> = {
                header: 'HeaderElement',
                homepage: 'HomeElement',
                services: 'ServicesElement',
                'about-us': 'AboutUsElement',
                contact: 'ContactElement',
                footer: 'FooterElement',
            };
            return componentMap[type] || 'div';
        },

        getElementStyles(element: any) {
            return {
                position: 'absolute',
                left: `${element.position?.x || 0}px`,
                top: `${element.position?.y || 0}px`,
                width: element.styles?.width || 'auto',
                zIndex: this.getElementZIndex(element.type), // Add z-index based on type
                ...element.styles,
            };
        },

        getElementZIndex(type: string) {
            // Assign z-index based on element type to ensure proper stacking
            const zIndexMap: Record<string, number> = {
                header: 100,
                homepage: 90,
                services: 80,
                'about-us': 70,
                contact: 60,
                footer: 50,
            };
            return zIndexMap[type] || 1;
        },

        toggleDevice(device: 'desktop' | 'tablet' | 'mobile') {
            this.device = device;
        },

        closePreview() {
            this.$emit('close');
        },
    },
});
</script>

<style scoped>
.header-element {
    position: absolute;
    top: 0 !important;
    left: 0 !important;
    width: 1000px !important;
}

.homepage-element {
    position: absolute;
    margin-top: none !important;
    left: 0 !important;
    width: 1000px !important;
}
.homepage-element .background-image {
    margin-top: 0px !important;
    background-size: 1000px 100vh !important;
}
.contact-element {
    width: 1000px !important;
}

.footer-element {
    bottom: 0 !important;
    left: 0 !important;
    width: 1000px !important;
    height: 80px !important;
    background-color: #2d3748 !important;
    color: white !important;
    padding: 20px !important;
    text-align: center !important;
}

.preview-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #f5f5f5;
    z-index: 1000;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    justify-content: center;
}

.preview-canvas {
    background-color: white;
    margin-bottom: 20px;
    position: relative;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.preview-controls {
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: flex;
    gap: 10px;
    background: white;
    padding: 10px;
    border-radius: 4px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
    z-index: 1001;
}
</style>
