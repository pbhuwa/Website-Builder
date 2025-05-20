<template>
    <el-table :data="websites" style="width: 100%">
        <el-table-column label="ID" prop="id" />
        <el-table-column label="Website" prop="name" />
        <el-table-column label="Date" prop="created_at" />
        <el-table-column align="right">
            <template #header>
                <el-input v-model="search" size="small" @input="filteredWebsites" placeholder="Search websites..." />
            </template>
            <template #default="scope">
                <el-button size="small" type="success" @click="showPreview(scope.row)"> Preview </el-button>
                <el-button size="small" type="danger" @click="handleDelete(scope.row)"> Delete </el-button>
            </template>
        </el-table-column>
    </el-table>
    <!-- Preview Dialog -->
    <el-dialog v-model="previewVisible" title="Website Preview" width="90%" top="5vh" fullscreen :show-close="false">
        <PreviewPage v-if="previewVisible" :elements="websiteData.elements" :canvasStyle="websiteData.canvasStyle" @close="previewVisible = false" />
    </el-dialog>
</template>

<script lang="ts">
import { View } from '@element-plus/icons-vue';
import { defineComponent } from 'vue';
import PreviewPage from './PreviewPage.vue';

// Define Website type
type Website = {
    id: number;
    name: string;
    created_at: string;
};

export default defineComponent({
    components: { PreviewPage, View },
    name: 'WebsiteTable',
    data() {
        return {
            search: '',
            websites: [] as Website[],
            previewVisible: false,
            websiteData: {
                elements: [],
                canvasStyle: {},
            },
        };
    },
    methods: {
        async showPreview(website: Website) {
            try {
                // Fetch the website data including elements and canvas style
                const response = await this.$api.get(`/api/website/${website.id}`);

                this.websiteData = {
                    elements: response.data.elements || [],
                    canvasStyle: response.data.canvasStyle || {},
                };
                this.previewVisible = true;
            } catch (error) {
                console.error('Error loading preview:', error);
            }
        },

        async filteredWebsites() {
            const searchTerm = this.search.trim().toLowerCase();
            if (!searchTerm) {
                return this.websites;
            }
            const response = await this.$api.get('/api/websites?search=' + searchTerm);
            this.websites = response.data;
        },

        async fetchWebsites() {
            try {
                const response = await this.$api.get('/api/websites');
                this.websites = response.data;
            } catch (error) {
                console.error('Error fetching websites:', error);
            }
        },

        async handleDelete(website: Website) {
            try {
                const confirmed = await this.$confirm(`Are you sure you want to delete ${website.name}?`);

                if (confirmed) {
                    const response = await this.$api.delete(`/api/delete-website/${website.id}`);

                    if (response.status === 200) {
                        this.$emit('websiteDeleted', website.id);
                        this.websites = this.websites.filter((w) => w.id !== website.id);
                        this.$alert(`Website ${website.name} deleted successfully.`);
                    } else {
                        this.$alert(`Failed to delete website ${website.name}.`, 'Error', 'error');
                    }
                }
            } catch (error) {
                this.$alert(`Error deleting website ${website.name}.`, 'Error', 'error');
            }
        },
    },
    mounted() {
        this.fetchWebsites();
    },
});
</script>
