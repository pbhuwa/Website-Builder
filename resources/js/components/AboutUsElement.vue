<template>
    <div
      class="about-us-element"
      :style="elementStyles"
      @click.stop="selectElement"
    >
      <!-- Background Section -->
      <div class="about-us-background" :style="backgroundStyles">
        <div class="overlay" :style="overlayStyles"></div>
      </div>

      <!-- Content Container -->
      <div class="about-us-content" :style="contentStyles">
        <!-- Title Section -->
        <div
          class="about-title"
          :style="titleStyles"
          @dblclick.stop="startEditing('title')"
        >
          <div v-if="!editing.title" v-html="formattedTitle"></div>
          <textarea
            v-else
            ref="titleEditor"
            v-model="element.title.text"
            @blur="stopEditing('title')"
            @keydown.enter.stop="stopEditing('title')"
            :style="titleStyles"
          />
        </div>

        <!-- Mission Section -->
        <div class="mission-section">
          <h3
            class="section-title"
            :style="sectionTitleStyles"
            @dblclick.stop="startEditing('missionTitle')"
          >
            <span v-if="!editing.missionTitle">{{ element.mission.title }}</span>
            <input
              v-else
              v-model="element.mission.title"
              @blur="stopEditing('missionTitle')"
              @keydown.enter.stop="stopEditing('missionTitle')"
            />
          </h3>
          <div
            class="section-content"
            :style="sectionContentStyles"
            @dblclick.stop="startEditing('missionContent')"
          >
            <div v-if="!editing.missionContent" v-html="formattedMissionContent"></div>
            <textarea
              v-else
              v-model="element.mission.content"
              @blur="stopEditing('missionContent')"
              @keydown.enter.stop="stopEditing('missionContent')"
            />
          </div>
        </div>

        <!-- Team Section -->
        <div class="team-section" v-if="element.showTeam">
          <h3
            class="section-title"
            :style="sectionTitleStyles"
            @dblclick.stop="startEditing('teamTitle')"
          >
            <span v-if="!editing.teamTitle">{{ element.team.title }}</span>
            <input
              v-else
              v-model="element.team.title"
              @blur="stopEditing('teamTitle')"
              @keydown.enter.stop="stopEditing('teamTitle')"
            />
          </h3>
          <div class="team-members">
            <div
              class="team-member"
              v-for="(member, index) in element.team.members"
              :key="index"
            >
              <div class="member-image-container">
                <img
                  :src="member.image || '/placeholder-profile.jpg'"
                  :alt="member.name"
                  class="member-image"
                />
              </div>
              <div class="member-details">
                <h4
                  @dblclick.stop="startEditingMember(index, 'name')"
                >
                  <span v-if="!editing.members[index]?.name">{{ member.name }}</span>
                  <input
                    v-else
                    v-model="member.name"
                    @blur="stopEditingMember(index, 'name')"
                    @keydown.enter.stop="stopEditingMember(index, 'name')"
                  />
                </h4>
                <p
                  @dblclick.stop="startEditingMember(index, 'position')"
                >
                  <span v-if="!editing.members[index]?.position">{{ member.position }}</span>
                  <input
                    v-else
                    v-model="member.position"
                    @blur="stopEditingMember(index, 'position')"
                    @keydown.enter.stop="stopEditingMember(index, 'position')"
                  />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Element Controls -->
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
          position: { x: 0, y: 0 },
          styles: {
            width: '1000px',
            minHeight: '600px',
            backgroundColor: '#ffffff'
          },
          backgroundStyles: {
            color: '#f5f5f5',
            image: '',
            opacity: 0.8,
            size: 'cover',
            position: 'center'
          },
          overlayStyles: {
            backgroundColor: 'rgba(0,0,0,0.3)'
          },
          title: {
            text: 'About Our Company',
            styles: {
              fontSize: '2.5rem',
              color: '#000000',
              textAlign: 'center',
              marginBottom: '2rem'
            }
          },
          contentStyles: {
            padding: '60px 20px',
            maxWidth: '1000px',
            margin: '0 auto',
            position: 'relative'
          },
          sectionTitleStyles: {
            fontSize: '1.8rem',
            color: '#333',
            marginBottom: '1rem'
          },
          sectionContentStyles: {
            fontSize: '1rem',
            lineHeight: '1.6',
            color: '#555'
          },
          mission: {
            title: 'Our Mission',
            content: 'We are dedicated to providing exceptional services and products that make a difference in people\'s lives. Our team works tirelessly to ensure customer satisfaction and innovation in everything we do.'
          },
          showTeam: true,
          team: {
            title: 'Meet Our Team',
            members: [
              {
                name: 'Bhuwanesh Kumar',
                position: 'CEO & Founder',
                image: '../../../public/person.jpg'
              },
              {
                name: 'Anil Kumar Sah',
                position: 'Creative Director',
                image: ''
              },
              {
                name: 'Subham Prasad',
                position: 'Creative Director',
                image: ''
              }
            ]
          },
          ...this.elementData
        },
        editing: {
          title: false,
          missionTitle: false,
          missionContent: false,
          teamTitle: false,
          members: []
        }
      };
    },
    computed: {
      elementStyles() {
        return {
          ...this.element.styles,
          position: 'absolute',
          left: `${this.element.position.x}px`,
          top: `${this.element.position.y}px`,
          cursor: this.isSelected ? 'move' : 'pointer',
          outline: this.isSelected ? '2px dashed #4CAF50' : 'none'
        };
      },
      backgroundStyles() {
        return {
          position: 'absolute',
          top: 0,
          left: 0,
          width: '100%',
          height: '100%',
          backgroundColor: this.element.backgroundStyles.color,
          backgroundImage: this.element.backgroundStyles.image
            ? `url(${this.element.backgroundStyles.image})`
            : 'none',
          backgroundSize: this.element.backgroundStyles.size,
          backgroundPosition: this.element.backgroundStyles.position,
          opacity: this.element.backgroundStyles.opacity,
          zIndex: 0
        };
      },
      overlayStyles() {
        return {
          position: 'absolute',
          top: 0,
          left: 0,
          width: '100%',
          height: '100%',
          backgroundColor: this.element.overlayStyles.backgroundColor,
          zIndex: 1
        };
      },
      contentStyles() {
        return {
          ...this.element.contentStyles,
          position: 'relative',
          zIndex: 2
        };
      },
      titleStyles() {
        return {
          ...this.element.title.styles,
          position: 'relative',
          zIndex: 3
        };
      },
      sectionTitleStyles() {
        return {
          ...this.element.sectionTitleStyles,
          position: 'relative',
          zIndex: 3
        };
      },
      sectionContentStyles() {
        return {
          ...this.element.sectionContentStyles,
          position: 'relative',
          zIndex: 3
        };
      },
      formattedTitle() {
        return this.element.title.text.replace(/\n/g, '<br>');
      },
      formattedMissionContent() {
        return this.element.mission.content.replace(/\n/g, '<br>');
      }
    },
    methods: {
      selectElement() {
        this.$emit('selected');
      },
      startEditing(field) {
        if (this.isSelected) {
          this.editing[field] = true;
          this.$nextTick(() => {
            const ref = `${field}Editor` in this.$refs
              ? this.$refs[`${field}Editor`]
              : this.$el.querySelector(`[v-model="element.${field}"]`);
            ref?.focus();
          });
        }
      },
      stopEditing(field) {
        this.editing[field] = false;
        this.$emit('update', this.element);
      },
    },
    watch: {
      elementData(newVal) {
        this.element = { ...this.element, ...newVal };
      }
    }
  };
  </script>

  <style scoped>
  .about-us-element {
    transition: all 0.2s ease;
  }

  .about-us-background {
    transition: all 0.3s ease;
  }

  .about-us-content {
    transition: all 0.3s ease;
  }

  .about-title {
    padding: 20px 0;
  }

  textarea {
    width: 100%;
    border: none;
    background: transparent;
    resize: none;
    outline: none;
    font-family: inherit;
    font-size: inherit;
    color: inherit;
    text-align: inherit;
  }

  .mission-section {
    margin-bottom: 40px;
  }

  .team-section {
    margin-top: 40px;
  }

  .team-members {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 20px;
  }

  .team-member {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }

  .member-image-container {
    position: relative;
    height: 200px;
    background: #f5f5f5;
  }

  .member-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .change-image-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
  }

  .member-details {
    padding: 15px;
  }

  .member-details h4 {
    margin: 0 0 5px 0;
    font-size: 1.2rem;
  }

  .member-details p {
    margin: 0;
    color: #666;
  }

  .add-member-btn {
    display: block;
    margin: 20px auto 0;
    padding: 10px 20px;
    background: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .element-controls {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
  }

  .element-controls button {
    background: rgba(0,0,0,0.7);
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
