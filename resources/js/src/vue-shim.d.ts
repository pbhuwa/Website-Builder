import Vue from "vue";

declare module "@vue/runtime-core" {
    interface ComponentCustomProperties {
        $alert: typeof import("vue-simple-alert").alert;
        $confirm: typeof import("vue-simple-alert").confirm;
        $prompt: typeof import("vue-simple-alert").prompt;
    }
}
