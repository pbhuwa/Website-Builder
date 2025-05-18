<template>
    <div
      class="header-element"
      :style="{
      position: 'absolute',
      top: '0',
      left: '0',
      width: '100%',
      background: '#dddddd',
      color: 'white',
      padding: '20px',
      cursor: 'pointer'
    }"
      @click.stop="selectElement"
    >
      <div class="header-container" :style="containerStyles">
        <!-- Logo -->
        <div class="logo" :style="logoStyles" v-if="element.showLogo">
          <img
            v-if="element.logoType === 'image' && element.logoImage"
            :src="element.logoImage"
            :alt="element.siteName"
            :style="logoImageStyles"
          >
          <span v-else :style="textLogoStyles">{{ element.siteName }}</span>
        </div>

        <!-- Navigation -->
        <nav class="navigation" :style="navStyles" v-if="element.showNavigation">
          <ul class="nav-list" :style="navListStyles">
            <li
              v-for="(item, index) in element.menuItems"
              :key="index"
              :style="navItemStyles"
            >
              <a :href="item.url" :style="navLinkStyles">{{ item.text }}</a>
            </li>
          </ul>
        </nav>

        <!-- CTA Button -->
        <button
          class="cta-button"
          :style="ctaStyles"
          v-if="element.showCta"
        >
          {{ element.ctaText }}
        </button>
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
          siteName: 'My Website',
          showLogo: true,
          logoType: 'text', // 'text' or 'image'
          logoImage: '',
          showNavigation: true,
          menuItems: [
            { text: 'Home', url: '#' },
            { text: 'Services', url: '#' },
            { text: 'About', url: '#' },
            { text: 'Contact', url: '#' }
          ],
          showCta: true,
          ctaText: 'Get Started',
          styles: {
            backgroundColor: '#ffffff',
            padding: '20px 0',
            boxShadow: '0 2px 10px rgba(0,0,0,0.1)',
            position: 'fixed',
            width: '100%',
            top: 0,
            left: 0,
            zIndex: 1000
          },
          containerStyles: {
            maxWidth: '1200px',
            margin: '0 auto',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'space-between',
            padding: '0 20px'
          },
          logoStyles: {
            fontSize: '24px',
            fontWeight: 'bold'
          },
          logoImageStyles: {
            height: '40px',
            width: 'auto'
          },
          textLogoStyles: {
            color: '#333333',
            textDecoration: 'none'
          },
          navStyles: {
            flex: 1
          },
          navListStyles: {
            display: 'flex',
            listStyle: 'none',
            margin: 0,
            padding: 0,
            justifyContent: 'center',
            gap: '30px'
          },
          navItemStyles: {
            margin: 0
          },
          navLinkStyles: {
            color: '#333333',
            textDecoration: 'none',
            fontWeight: '500',
            transition: 'color 0.3s',
            '&:hover': {
              color: '#4CAF50'
            }
          },
          ctaStyles: {
            backgroundColor: '#4CAF50',
            color: 'white',
            border: 'none',
            padding: '10px 20px',
            borderRadius: '4px',
            cursor: 'pointer',
            fontWeight: 'bold',
            transition: 'background-color 0.3s',
            '&:hover': {
              backgroundColor: '#45a049'
            }
          },
          ...this.elementData
        }
      };
    },
    computed: {
      elementStyles() {
        return {
          ...this.element.styles,
          cursor: this.isSelected ? 'move' : 'pointer',
          outline: this.isSelected ? '2px dashed #4CAF50' : 'none'
        };
      },
      containerStyles() {
        return this.element.containerStyles;
      },
      logoStyles() {
        return this.element.logoStyles;
      },
      logoImageStyles() {
        return this.element.logoImageStyles;
      },
      textLogoStyles() {
        return this.element.textLogoStyles;
      },
      navStyles() {
        return this.element.navStyles;
      },
      navListStyles() {
        return this.element.navListStyles;
      },
      navItemStyles() {
        return this.element.navItemStyles;
      },
      navLinkStyles() {
        return this.element.navLinkStyles;
      },
      ctaStyles() {
        return this.element.ctaStyles;
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
  .header-element {
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

  .navigation a:hover {
    color: #4CAF50 !important;
  }

  .cta-button:hover {
    background-color: #45a049 !important;
  }
  </style>
