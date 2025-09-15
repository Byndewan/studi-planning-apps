<template>
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Stepper Header -->
    <div class="border-b border-gray-100">
      <nav class="flex overflow-x-auto">
        <button
          v-for="(step, index) in steps"
          :key="step.name"
          @click="currentStep = index"
          :class="[
            'px-6 py-4 text-sm font-medium whitespace-nowrap flex-shrink-0 border-b-2 transition-all duration-200',
            currentStep === index
              ? 'border-indigo-500 text-indigo-600 bg-indigo-50'
              : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50'
          ]"
        >
          <div class="flex items-center space-x-2">
            <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold"
                 :class="currentStep === index ? 'bg-indigo-500 text-white' : 'bg-gray-200 text-gray-600'">
              {{ index + 1 }}
            </div>
            <span>{{ step.label }}</span>
          </div>
        </button>
      </nav>
    </div>

    <!-- Stepper Content -->
    <div class="p-8">
      <!-- Survey Step -->
      <div v-if="currentStep === 0" class="space-y-4">
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Survey the Material</h3>
          <p class="text-sm text-gray-600 mt-1">Get an overview before diving in</p>
        </div>
        <textarea
          v-model="formData.survey_notes"
          @input="debouncedSave"
          placeholder="Skim through headings, subheadings, images, and summaries. Note down the main ideas and structure."
          class="form-input w-full h-48 p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        ></textarea>
      </div>

      <!-- Questions Step -->
      <div v-if="currentStep === 1" class="space-y-4">
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Generate Questions</h3>
          <p class="text-sm text-gray-600 mt-1">Turn headings into questions to guide your reading</p>
        </div>
        <div class="space-y-3">
          <div v-for="(question, index) in formData.questions" :key="index" class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
              <span class="text-sm font-medium text-gray-600">{{ index + 1 }}</span>
            </div>
            <input
              v-model="formData.questions[index]"
              @input="debouncedSave"
              :placeholder="`Question ${index + 1}`"
              class="form-input flex-1"
            />
          </div>
        </div>
        <button
          @click="addQuestion"
          class="flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium"
        >
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Add Question
        </button>
      </div>

      <!-- Read Step -->
      <div v-if="currentStep === 2" class="space-y-4">
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Read Actively</h3>
          <p class="text-sm text-gray-600 mt-1">Read carefully while seeking answers to your questions</p>
        </div>
        <textarea
          v-model="formData.read_notes"
          @input="debouncedSave"
          placeholder="Read the material carefully while seeking answers to your questions. Take notes on key concepts."
          class="form-input w-full h-48 p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        ></textarea>
      </div>

      <!-- Recite Step -->
      <div v-if="currentStep === 3" class="space-y-4">
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Recite and Summarize</h3>
          <p class="text-sm text-gray-600 mt-1">Summarize what you've learned in your own words</p>
        </div>
        <textarea
          v-model="formData.recite_notes"
          @input="debouncedSave"
          placeholder="Summarize what you've learned in your own words. Try to answer your questions without looking at the material."
          class="form-input w-full h-48 p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        ></textarea>
      </div>

      <!-- Review Step -->
      <div v-if="currentStep === 4" class="space-y-4">
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Review the Material</h3>
          <p class="text-sm text-gray-600 mt-1">Reinforce your understanding</p>
        </div>
        <textarea
          v-model="formData.review_notes"
          @input="debouncedSave"
          placeholder="Go back over the material to reinforce your understanding. Identify any gaps in your knowledge."
          class="form-input w-full h-48 p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        ></textarea>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex justify-between mt-8 pt-6 border-t border-gray-100">
        <button
          @click="previousStep"
          :disabled="currentStep === 0"
          :class="[
            'px-6 py-2 rounded-xl text-sm font-medium transition-all duration-200',
            currentStep === 0
              ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
              : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200 hover:border-gray-300'
          ]"
        >
          <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
          Previous
        </button>

        <button
          v-if="currentStep < steps.length - 1"
          @click="nextStep"
          class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-colors duration-200"
        >
          Next
          <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </button>

        <button
          v-else
          @click="completeSession"
          class="px-6 py-2 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition-colors duration-200"
        >
          Complete Session
          <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Auto-save Indicator -->
    <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-xs text-gray-600 flex items-center">
      <div
        class="w-2 h-2 rounded-full mr-2"
        :class="saving ? 'bg-yellow-400 animate-pulse' : 'bg-green-400'"
      ></div>
      {{ saving ? 'Saving...' : 'All changes saved' }}
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, watch, onMounted } from 'vue'
import { debounce } from 'lodash'

const props = defineProps({
  sessionId: {
    type: Number,
    default: null
  },
  courseId: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['session-completed'])

const steps = [
  { name: 'survey', label: 'Survey' },
  { name: 'questions', label: 'Questions' },
  { name: 'read', label: 'Read' },
  { name: 'recite', label: 'Recite' },
  { name: 'review', label: 'Review' }
]

const currentStep = ref(0)
const saving = ref(false)
const formData = reactive({
  survey_notes: '',
  questions: ['', '', ''],
  read_notes: '',
  recite_notes: '',
  review_notes: ''
})

// Load saved data if sessionId is provided
onMounted(async () => {
  if (props.sessionId) {
    try {
      const response = await axios.get(`/api/sq3r-sessions/${props.sessionId}`)
      Object.assign(formData, response.data)
    } catch (error) {
      console.error('Error loading session data:', error)
    }
  }
})

const addQuestion = () => {
  formData.questions.push('')
}

const previousStep = () => {
  if (currentStep.value > 0) {
    currentStep.value--
  }
}

const nextStep = () => {
  if (currentStep.value < steps.length - 1) {
    currentStep.value++
  }
}

const saveSession = async () => {
  saving.value = true
  try {
    const url = props.sessionId
      ? `/api/sq3r-sessions/${props.sessionId}`
      : '/api/sq3r-sessions'

    const method = props.sessionId ? 'put' : 'post'

    await axios[method](url, {
      ...formData,
      course_id: props.courseId
    })
  } catch (error) {
    console.error('Error saving session:', error)
  } finally {
    saving.value = false
  }
}

const debouncedSave = debounce(saveSession, 1000)

const completeSession = async () => {
  await saveSession()
  emit('session-completed')
}

// Auto-save when changing steps
watch(currentStep, debouncedSave)
</script>
