<template>
  <div class="concept-map-container bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
      <h3 class="text-lg font-medium text-gray-900">{{ title }}</h3>
      <div class="flex space-x-2">
        <button @click="addNode" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
          Add Node
        </button>
        <button @click="autoLayout" class="px-3 py-1 bg-green-600 text-white rounded text-sm">
          Auto Layout
        </button>
        <button @click="save" class="px-3 py-1 bg-gray-600 text-white rounded text-sm">
          Save
        </button>
      </div>
    </div>

    <div ref="canvas" class="w-full h-96 border-b border-gray-200 relative overflow-auto">
      <!-- Nodes -->
      <div v-for="node in nodes" :key="node.id"
           :style="{ left: node.position.x + 'px', top: node.position.y + 'px' }"
           class="absolute bg-white border border-gray-300 rounded p-2 shadow-sm cursor-move min-w-32"
           @mousedown="startDrag(node, $event)">
        <div class="font-medium text-sm">{{ node.data.label }}</div>
        <div class="text-xs text-gray-500">Frequency: {{ node.data.frequency }}</div>
      </div>

      <!-- Edges will be drawn with SVG -->
      <svg class="absolute top-0 left-0 w-full h-full pointer-events-none">
        <line v-for="edge in edges" :key="edge.id"
              :x1="getNodePosition(edge.source).x + 64"
              :y1="getNodePosition(edge.source).y + 24"
              :x2="getNodePosition(edge.target).x + 64"
              :y2="getNodePosition(edge.target).y + 24"
              stroke="#4B5563" stroke-width="2" />
      </svg>
    </div>

    <div class="p-4 bg-gray-50 text-xs text-gray-500 flex items-center">
      <div class="w-2 h-2 rounded-full mr-2" :class="saving ? 'bg-yellow-400 animate-pulse' : 'bg-green-400'"></div>
      {{ saving ? 'Saving...' : 'All changes saved' }}
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { debounce } from 'lodash'

export default {
  props: {
    initialNodes: {
      type: Array,
      default: () => []
    },
    initialEdges: {
      type: Array,
      default: () => []
    },
    title: {
      type: String,
      default: 'Concept Map'
    },
    autosaveUrl: String
  },

  setup(props) {
    const nodes = ref([...props.initialNodes])
    const edges = ref([...props.initialEdges])
    const saving = ref(false)
    const canvas = ref(null)
    const draggingNode = ref(null)
    const dragOffset = ref({ x: 0, y: 0 })

    const getNodePosition = (nodeId) => {
      const node = nodes.value.find(n => n.id === nodeId)
      return node ? node.position : { x: 0, y: 0 }
    }

    const startDrag = (node, event) => {
      draggingNode.value = node
      const rect = event.target.getBoundingClientRect()
      dragOffset.value = {
        x: event.clientX - rect.left,
        y: event.clientY - rect.top
      }

      document.addEventListener('mousemove', onDrag)
      document.addEventListener('mouseup', stopDrag)
    }

    const onDrag = (event) => {
      if (!draggingNode.value) return

      const canvasRect = canvas.value.getBoundingClientRect()
      draggingNode.value.position = {
        x: event.clientX - canvasRect.left - dragOffset.value.x,
        y: event.clientY - canvasRect.top - dragOffset.value.y
      }
    }

    const stopDrag = () => {
      draggingNode.value = null
      document.removeEventListener('mousemove', onDrag)
      document.removeEventListener('mouseup', stopDrag)
      debouncedSave()
    }

    const addNode = () => {
      const newNode = {
        id: `node-${Date.now()}`,
        type: 'concept',
        position: { x: 100, y: 100 },
        data: { label: 'New Concept', frequency: 1 }
      }
      nodes.value.push(newNode)
      debouncedSave()
    }

    const autoLayout = () => {
      // Simple grid layout
      const cols = Math.ceil(Math.sqrt(nodes.value.length))
      nodes.value.forEach((node, index) => {
        node.position = {
          x: (index % cols) * 200 + 50,
          y: Math.floor(index / cols) * 100 + 50
        }
      })
      debouncedSave()
    }

    const save = async () => {
      saving.value = true
      try {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000))
        console.log('Saved concept map:', { nodes: nodes.value, edges: edges.value })
      } catch (error) {
        console.error('Error saving concept map:', error)
      } finally {
        saving.value = false
      }
    }

    const debouncedSave = debounce(save, 2000)

    onMounted(() => {
      if (nodes.value.length === 0) {
        autoLayout()
      }
    })

    return {
      nodes,
      edges,
      saving,
      canvas,
      getNodePosition,
      startDrag,
      addNode,
      autoLayout,
      save,
      debouncedSave
    }
  }
}
</script>
