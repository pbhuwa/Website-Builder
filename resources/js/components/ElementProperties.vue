<template>
    <div class="properties-form">
        <!-- Common Properties -->
        <div class="form-group">
            <label>Position X</label>
            <input type="number" v-model="localElement.position.x" @change="updateElement" />
        </div>

        <div class="form-group">
            <label>Position Y</label>
            <input type="number" v-model="localElement.position.y" @change="updateElement" />
        </div>

        <!-- Header Properties -->
        <template v-if="element.type === 'header'">
            <div class="form-group">
                <label>Site Name</label>
                <input type="text" v-model="localElement.siteName" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" v-model="localElement.showLogo" @change="updateElement" />
                    Show Logo
                </label>
            </div>

            <template v-if="localElement.showLogo">
                <div class="form-group">
                    <label>Logo Type</label>
                    <select v-model="localElement.logoType" @change="updateElement">
                        <option value="text">Text</option>
                        <option value="image">Image</option>
                    </select>
                </div>

                <div class="form-group" v-if="localElement.logoType === 'image'">
                    <label>Logo Image</label>
                    <input type="text" v-model="localElement.logoImage" @change="updateElement" placeholder="Image URL" />
                    <input type="file" @change="handleLogoUpload" />
                </div>
            </template>

            <div class="form-group">
                <label>
                    <input type="checkbox" v-model="localElement.showNavigation" @change="updateElement" />
                    Show Navigation
                </label>
            </div>

            <div class="form-group" v-if="localElement.showNavigation">
                <label>Menu Items</label>
                <div v-for="(item, index) in localElement.menuItems" :key="index" class="menu-item">
                    <input type="text" v-model="item.text" @change="updateElement" placeholder="Menu Text" />
                    <input type="text" v-model="item.url" @change="updateElement" placeholder="URL" />
                    <button @click="removeMenuItem(index)">Remove</button>
                </div>
                <button @click="addMenuItem">Add Menu Item</button>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" v-model="localElement.showCta" @change="updateElement" />
                    Show CTA Button
                </label>
            </div>

            <div class="form-group" v-if="localElement.showCta">
                <label>CTA Text</label>
                <input type="text" v-model="localElement.ctaText" @change="updateElement" />
            </div>
        </template>

        <!-- Home Properties -->
        <template v-if="element.type === 'homepage'">
            <!-- Image Size Controls -->
            <div class="form-group">
                <label>Image Size Mode</label>
                <select v-model="localElement.backgroundStyles.sizeMode" @change="updateElement">
                <option value="cover">Cover</option>
                <option value="contain">Contain</option>
                <option value="custom">Custom Size</option>
                </select>
            </div>

            <template v-if="localElement.backgroundStyles.sizeMode === 'custom'">
                <div class="form-group">
                <label>Width</label>
                <input
                    type="text"
                    v-model="localElement.backgroundStyles.customWidth"
                    @change="updateElement"
                    placeholder="e.g., 100% or 500px"
                >
                </div>
                <div class="form-group">
                <label>Height</label>
                <input
                    type="text"
                    v-model="localElement.backgroundStyles.customHeight"
                    @change="updateElement"
                    placeholder="e.g., auto or 300px"
                >
                </div>
            </template>

            <!-- Max Dimensions Warning -->
            <div class="bg-yellow-50 p-2 text-sm mb-4" v-if="localElement.maxImageSize">
                Max recommended dimensions: {{ localElement.maxImageSize.width }}×{{ localElement.maxImageSize.height }}px
            </div>
        </template>

        <!-- About Us specific -->
        <template v-if="element.type === 'about-us'">
            <!-- Background Settings -->
            <div class="form-group">
                <label>Background Color</label>
                <input type="color" v-model="localElement.backgroundStyles.color" @change="updateElement">
            </div>

            <div class="form-group">
                <label>Background Image</label>
                <button @click="triggerImageUpload">Upload Image</button>
                <input type="file" ref="bgImageInput" @change="handleBgImageUpload" style="display: none">
            </div>

            <!-- Content Settings -->
            <div class="form-group">
                <label>Show Team Section</label>
                <input type="checkbox" v-model="localElement.showTeam" @change="updateElement">
            </div>

            <!-- Team Member Limit -->
            <div class="form-group" v-if="localElement.showTeam">
                <label>Max Team Members</label>
                <input type="number" v-model="localElement.team.maxMembers" min="1" max="12" @change="updateElement">
            </div>
        </template>

        <!-- Footer Properties -->
        <template v-if="element.type === 'footer'">
            <div class="form-group">
                <label>Footer Text</label>
                <input
                type="text"
                v-model="localElement.text"
                @change="updateElement"
                />
            </div>

            <div class="form-group">
                <label>Background Color</label>
                <input
                type="color"
                v-model="localElement.styles.backgroundColor"
                @change="updateElement"
                />
            </div>

            <div class="form-group">
                <label>Text Color</label>
                <input
                type="color"
                v-model="localElement.styles.color"
                @change="updateElement"
                />
            </div>
        </template>

        <!-- Text Block Specific -->
        <template v-if="element.type === 'text-block'">
            <div class="form-group">
                <label>Content</label>
                <textarea v-model="localElement.content" @change="updateElement"></textarea>
            </div>

            <div class="form-group">
                <label>Font Size</label>
                <input type="text" v-model="localElement.styles.fontSize" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>Color</label>
                <input type="color" v-model="localElement.styles.color" @change="updateElement" />
            </div>
        </template>

        <!-- Image Specific -->
        <template v-if="element.type === 'image'">
            <div class="form-group">
                <label>Image URL</label>
                <input type="text" v-model="localElement.src" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>Alt Text</label>
                <input type="text" v-model="localElement.alt" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>Width</label>
                <input type="text" v-model="localElement.styles.width" @change="updateElement" />
            </div>
        </template>

        <!-- Button Specific -->
        <template v-if="element.type === 'button'">
            <div class="form-group">
                <label>Button Text</label>
                <input type="text" v-model="localElement.text" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>Background Color</label>
                <input type="color" v-model="localElement.styles.backgroundColor" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>Text Color</label>
                <input type="color" v-model="localElement.styles.color" @change="updateElement" />
            </div>
        </template>

        <!-- Input Specific -->
        <template v-if="element.type === 'input'">
            <div class="form-group">
                <label>Input Label</label>
                <input type="text" v-model="localElement.label" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>Input Type</label>
                <select v-model="localElement.inputType" @change="updateElement">
                    <option value="text">Text</option>
                    <option value="email">Email</option>
                    <option value="password">Password</option>
                    <option value="number">Number</option>
                </select>
            </div>

            <div class="form-group">
                <label>Placeholder</label>
                <input type="text" v-model="localElement.placeholder" @change="updateElement" />
            </div>
        </template>

        <!-- Card Specific -->
        <template v-if="element.type === 'card'">
            <!-- Card Styling -->
            <div class="form-group">
                <label>Background Color</label>
                <input type="color" v-model="localElement.styles.backgroundColor" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>Border Radius (px)</label>
                <input type="number" v-model="localElement.styles.borderRadius" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>Padding (px)</label>
                <input type="number" v-model="localElement.bodyStyles.padding" @change="updateElement" />
            </div>

            <!-- Text Styling -->
            <div class="form-group">
                <label>Text Color</label>
                <input type="color" v-model="localElement.textStyles.color" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>Font Size (px)</label>
                <input type="number" v-model="localElement.textStyles.fontSize" @change="updateElement" />
            </div>

            <div class="form-group">
                <label>Line Height</label>
                <input type="number" step="0.1" v-model="localElement.textStyles.lineHeight" @change="updateElement" />
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            element: Object
        },
        data() {
            return {
                localElement: JSON.parse(JSON.stringify(this.element))
            };
        },
        watch: {
            element: {
                deep: true,
                handler(newVal) {
                    this.localElement = JSON.parse(JSON.stringify(newVal));
                }
            }
        },
        methods: {
            updateElement() {
                this.$emit('update', this.localElement);
            },
            triggerImageUpload() {
                this.$refs.bgImageInput.click();
            },
            async handleBgImageUpload(event) {
                const file = event.target.files[0];
                if (!file) return;

                try {
                    const formData = new FormData();
                    formData.append('image', file);

                    const response = await axios.post('/api/upload-image', formData);
                    this.localElement.backgroundImage = response.data.url;
                    this.updateElement();
                } catch (error) {
                    console.error('Upload failed:', error);
                }
            },
        }
    };
</script>

<style scoped>
    .properties-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    label {
        font-weight: 500;
        font-size: 14px;
    }

    input, textarea, select {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    textarea {
        min-height: 80px;
        resize: vertical;
    }

    input[type="color"] {
        height: 40px;
        padding: 2px;
        cursor: pointer;
    }
</style>
