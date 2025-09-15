<template>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Stepper Header -->
    <div class="border-b border-gray-200">
      <nav class="flex overflow-x-auto">
        <button
          v-for="(step, index) in steps"
          :key="step.name"
          @click="currentStep = index"
          :class="[
            'px-4 py-3 text-sm font-medium whitespace-nowrap flex-shrink-0 border-b-2',
            currentStep === index
              ? 'border-blue-500 text-blue-600'
              : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
          ]"
        >
          {{ step.label }}
        </button>
      </nav>
    </div>

    <!-- Stepper Content -->
    <div class="p-6">
      <!-- Survey Step -->
      <div v-if="currentStep === 0">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Survey the Material</h3>
        <textarea
          v-model="formData.survey_notes"
          @input="debouncedSave"
          placeholder="Skim through headings, subheadings, images, and summaries. Note down the main ideas and structure."
          class="w-full h-40 p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
        ></textarea>
      </div>

      <!-- Questions Step -->
      <div v-if="currentStep === 1">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Generate Questions</h3>
        <div v-for="(question, index) in formData.questions" :key="index" class="mb-3">
          <input
            v-model="formData.questions[index]"
            @input="debouncedSave"
            :placeholder="`Question ${index + 1}`"
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
        <button
          @click="addQuestion"
          class="mt-2 flex items-center text-sm text-blue-600 hover:text-blue-800"
        >
          <PlusIcon class="w-4 h-4 mr-1" />
          Add Question
        </button>
      </div>

      <!-- Read Step -->
      <div v-if="currentStep === 2">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Read Actively</h3>
        <textarea
          v-model="formData.read_notes"
          @input="debouncedSave"
          placeholder="Read the material carefully while seeking answers to your questions. Take notes on key concepts."
          class="w-full h-40 p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
        ></textarea>
      </div>

      <!-- Recite Step -->
      <div v-if="currentStep === 3">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Recite and Summarize</h3>
        <textarea
          v-model="formData.recite_notes"
          @input="debouncedSave"
          placeholder="Summarize what you've learned in your own words. Try to answer your questions without looking at the material."
          class="w-full h-40 p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
        ></textarea>
      </div>

      <!-- Review Step -->
      <div v-if="currentStep === 4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Review the Material</h3>
        <textarea
          v-model="formData.review_notes"
          @input="debouncedSave"
          placeholder="Go back over the material to reinforce your understanding. Identify any gaps in your knowledge."
          class="w-full h-40 p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
        ></textarea>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex justify-between mt-6">
        <button
          @click="previousStep"
          :disabled="currentStep === 0"
          :class="[
            'px-4 py-2 rounded-md text-sm font-medium',
            currentStep === 0
              ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
              : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
          ]"
        >
          Previous
        </button>

        <button
          v-if="currentStep < steps.length - 1"
          @click="nextStep"
          class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700"
        >
          Next
        </button>

        <button
          v-else
          @click="completeSession"
          class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700"
        >
          Complete Session
        </button>
      </div>
    </div>

    <!-- Auto-save Indicator -->
    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex items-center">
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
import { PlusIcon } from '@heroicons/vue/outline'
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
