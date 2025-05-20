<template>
    <div class="services-element" :style="elementStyles" @click.stop="selectElement">
        <div class="container">
            <h2 class="title" :style="element.title.styles">
                <span v-if="!editing.title">{{ element.title.text }}</span>
                <input v-else v-model="element.title.text" />
            </h2>

            <div class="grid">
                <div v-for="(service, index) in element.services" :key="index" class="card">
                    <div class="icon" :style="element.iconStyles">{{ service.icon }}</div>
                    <h3 class="service-title">{{ service.title }}</h3>
                    <p class="service-description">{{ service.description }}</p>
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
        isSelected: Boolean,
    },
    data() {
        return {
            element: {
                title: { text: 'Our Services', styles: { fontSize: '2rem', color: '#2c3e50' } },
                iconStyles: { fontSize: '2rem', color: '#3498db' },
                services: [
                    { icon: '🛠️', title: 'Web Development', description: 'Tailored web solutions.' },
                    { icon: '📱', title: 'Mobile Apps', description: 'iOS and Android apps.' },
                ],
                ...this.elementData,
            },
            editing: { title: false, services: [] },
        };
    },
    computed: {
        elementStyles() {
            return {
                position: 'absolute',
                left: `${this.element.position.x}px`,
                top: `${this.element.position.y}px`,
                width: '100%',
                height: 'auto',
                cursor: this.isSelected ? 'move' : 'pointer',
                outline: this.isSelected ? '2px dashed #4CAF50' : 'none',
                padding: '5px',
                backgroundColor: 'transparent',
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
            this.element = { ...newVal };
        },
    },
};
</script>

<style scoped>
.services-element {
    padding: 40px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.container {
    max-width: 1200px;
    margin: 0 auto;
}
.title {
    text-align: center;
    margin-bottom: 20px;
}
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
}
.card {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    transition: transform 0.3s;
}
.card:hover {
    transform: translateY(-5px);
}
.icon {
    font-size: 2rem;
    margin-bottom: 10px;
}
.add-btn {
    background-color: #3498db;
    color: #fff;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}
.add-btn:hover {
    background-color: #2980b9;
}
.element-controls {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
}
.element-controls button {
    background: rgba(253, 0, 0, 0.7);
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
