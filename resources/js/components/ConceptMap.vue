<template>
  <div class="concept-map-wrapper">
    <div class="concept-map-container" ref="mapContainer">
      <!-- Toolbar -->
      <div class="concept-map-toolbar">
        <div class="flex items-center space-x-2">
          <button @click="addNode" class="btn-primary text-sm">
            <svg
              class="w-4 h-4 mr-1"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 4v16m8-8H4"
              ></path>
            </svg>
            Add Concept
          </button>
          <button @click="autoLayout" class="btn-secondary text-sm">
            <svg
              class="w-4 h-4 mr-1"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
              ></path>
            </svg>
            Auto Layout
          </button>
          <button @click="saveMap" class="btn-secondary text-sm">
            <svg
              class="w-4 h-4 mr-1"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
              ></path>
            </svg>
            Save
          </button>
        </div>
        <div class="text-sm text-gray-600">
          {{ localNodes.length }} concepts, {{ localEdges.length }} connections
        </div>
      </div>

      <!-- Canvas -->
      <div class="concept-map-canvas" ref="canvas">
        <!-- Edges SVG -->
        <svg
          class="edges-svg"
          :width="canvasWidth"
          :height="canvasHeight"
          viewBox="0 0 24 24"
        >
          <defs>
            <marker
              id="arrowhead"
              markerWidth="10"
              markerHeight="7"
              refX="9"
              refY="3.5"
              orient="auto"
            >
              <polygon points="0 0, 10 3.5, 0 7" fill="#6b7280" />
            </marker>
          </defs>
          <line
            v-for="edge in localEdges"
            :key="edge.id"
            :x1="getNodeCenter(edge.source).x"
            :y1="getNodeCenter(edge.source).y"
            :x2="getNodeCenter(edge.target).x"
            :y2="getNodeCenter(edge.target).y"
            stroke="#6b7280"
            stroke-width="2"
            stroke-dasharray="5,5"
            marker-end="url(#arrowhead)"
          />
          <text
            v-for="edge in localEdges"
            :key="'label-' + edge.id"
            :x="
              (getNodeCenter(edge.source).x + getNodeCenter(edge.target).x) / 2
            "
            :y="
              (getNodeCenter(edge.source).y + getNodeCenter(edge.target).y) /
                2 -
              5
            "
            text-anchor="middle"
            class="edge-label"
            @dblclick="editEdge(edge)"
          >
            {{ edge.label || "relates to" }}
          </text>
        </svg>

        <!-- Nodes -->
        <div
          v-for="node in localNodes"
          :key="node.id"
          :id="node.id"
          :style="{
            left: node.position.x + 'px',
            top: node.position.y + 'px',
            width: node.style?.width || '80px',
            height: node.style?.height || '60px',
            backgroundColor: node.style?.background || '#4ECDC4',
            fontSize: node.style?.fontSize || '12px',
          }"
          class="concept-node"
          @mousedown="startDrag(node, $event)"
          @dblclick="editNode(node)"
        >
          <div class="node-label">{{ node.data.label }}</div>
          <div v-if="node.data.frequency > 1" class="node-frequency">
            {{ node.data.frequency }}
          </div>
          <button class="node-delete" @click.stop="deleteNode(node.id)">
            ×
          </button>
        </div>

        <!-- 🔥 **EMPTY STATE** --->
        <div v-if="localNodes.length === 0" class="empty-state">
          <div class="empty-icon">
            <svg
              class="w-16 h-16 text-gray-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 8h.01M12 13h.01M15 13h.01"
              ></path>
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mt-4">
            No concepts yet
          </h3>
          <p class="text-gray-600 mt-2">
            Click "Add Concept" to create your first concept!
          </p>
        </div>
      </div>

      <!-- Status bar -->
      <div class="concept-map-status">
        <div class="flex items-center space-x-2">
          <div
            class="w-2 h-2 rounded-full"
            :class="saving ? 'bg-yellow-400 animate-pulse' : 'bg-green-400'"
          ></div>
          <span class="text-xs text-gray-600">{{ statusText }}</span>
        </div>
        <div class="text-xs text-gray-500">
          Double-click nodes to edit • Drag to move • Click "Add Concept" to
          create
        </div>
      </div>
    </div>

    <!-- Node Edit Modal -->
    <div v-if="editingNode" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <h3 class="text-lg font-semibold mb-4">Edit Concept</h3>
        <div class="space-y-4">
          <div>
            <label class="form-label">Label</label>
            <input
              v-model="editingNode.data.label"
              class="form-input"
              type="text"
            />
          </div>
          <div>
            <label class="form-label">Category</label>
            <select v-model="editingNode.data.category" class="form-input">
              <option value="main_concept">Main Concept</option>
              <option value="sub_concept">Sub Concept</option>
              <option value="detail">Detail</option>
            </select>
          </div>
          <div>
            <label class="form-label">Color</label>
            <input
              v-model="editingNode.style.background"
              type="color"
              class="form-input"
            />
          </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
          <button @click="closeModal" class="btn-secondary">Cancel</button>
          <button @click="saveNodeEdit" class="btn-primary">Save</button>
        </div>
      </div>
    </div>

    <!-- Edge Edit Modal -->
    <div v-if="editingEdge" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <h3 class="text-lg font-semibold mb-4">Edit Connection</h3>
        <div class="space-y-4">
          <div>
            <label class="form-label">Relationship</label>
            <input
              v-model="editingEdge.label"
              class="form-input"
              type="text"
              placeholder="e.g., relates to, causes, includes"
            />
          </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
          <button @click="closeModal" class="btn-secondary">Cancel</button>
          <button @click="saveEdgeEdit" class="btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive, computed, watch, onMounted, nextTick } from "vue";
import axios from "axios";

export default {
  name: "ConceptMap",
  props: {
    nodes: {
      type: Array,
      default: () => [],
    },
    edges: {
      type: Array,
      default: () => [],
    },
    title: {
      type: String,
      default: "Concept Map",
    },
    autosaveUrl: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    // 🔥 **CRITICAL FIX**: Proper data initialization
    const localNodes = ref([]);
    const localEdges = ref([]);
    const editingNode = ref(null);
    const editingEdge = ref(null);
    const draggingNode = ref(null);
    const dragOffset = ref({ x: 0, y: 0 });
    const saving = ref(false);
    const statusText = ref("Ready");
    const canvas = ref(null);
    const canvasWidth = ref(800);
    const canvasHeight = ref(600);

    // 🔥 **CRITICAL FIX**: Proper data loading with validation
    const loadData = () => {
      try {
        if (props.nodes && Array.isArray(props.nodes)) {
          localNodes.value = props.nodes.map((node) => ({
            ...node,
            position: node.position || {
              x: Math.random() * 400 + 50,
              y: Math.random() * 300 + 50,
            },
            data: node.data || { label: "Unknown", frequency: 1 },
            style: node.style || {
              background: "#4ECDC4",
              width: "80px",
              height: "60px",
            },
          }));
        }

        if (props.edges && Array.isArray(props.edges)) {
          localEdges.value = props.edges.map((edge) => ({
            ...edge,
            label: edge.label || "relates to",
            style: edge.style || { stroke: "#6b7280", strokeWidth: 2 },
          }));
        }

        console.log("✅ Local nodes:", localNodes.value);
        console.log("✅ Local edges:", localEdges.value);
      } catch (error) {
        console.error("❌ Error loading concept map data:", error);
        localNodes.value = [];
        localEdges.value = [];
      }
    };

    // Initialize canvas size
    onMounted(() => {
      nextTick(() => {
        if (canvas.value) {
          canvasWidth.value = canvas.value.clientWidth;
          canvasHeight.value = canvas.value.clientHeight;
        }
        console.log("🔥 Props nodes:", props.nodes);
        console.log("🔥 Props edges:", props.edges);
        loadData();
      });
    });

    // Watch for prop changes
    watch(
      () => props.nodes,
      (newNodes) => {
        loadData();
      },
      { deep: true }
    );

    watch(
      () => props.edges,
      (newEdges) => {
        loadData();
      },
      { deep: true }
    );

    // Helper functions
    const getNodeById = (id) => {
      return localNodes.value.find((node) => node.id === id);
    };

    const getNodeCenter = (nodeId) => {
      const node = getNodeById(nodeId);
      if (!node) return { x: 0, y: 0 };

      const nodeEl = document.getElementById(nodeId);
      if (!nodeEl) return { x: node.position.x + 40, y: node.position.y + 30 };

      const rect = nodeEl.getBoundingClientRect();

      return {
        x: node.position.x + rect.width / 2,
        y: node.position.y + rect.height / 2,
      };
    };

    // Drag and drop functionality
    const startDrag = (node, event) => {
      draggingNode.value = node;
      const rect = event.target.getBoundingClientRect();
      dragOffset.value = {
        x: event.clientX - rect.left,
        y: event.clientY - rect.top,
      };

      document.addEventListener("mousemove", onDrag);
      document.addEventListener("mouseup", stopDrag);
    };

    const onDrag = (event) => {
      if (!draggingNode.value) return;

      const canvasRect = canvas.value.getBoundingClientRect();
      draggingNode.value.position = {
        x: Math.max(0, event.clientX - canvasRect.left - dragOffset.value.x),
        y: Math.max(0, event.clientY - canvasRect.top - dragOffset.value.y),
      };
    };

    const stopDrag = () => {
      if (draggingNode.value) {
        saveChanges();
      }
      draggingNode.value = null;
      document.removeEventListener("mousemove", onDrag);
      document.removeEventListener("mouseup", stopDrag);
    };

    // Node operations
    const addNode = () => {
      const newNode = {
        id: `node-${Date.now()}`,
        type: "concept",
        position: {
          x: Math.random() * (canvasWidth.value - 100) + 50,
          y: Math.random() * (canvasHeight.value - 100) + 50,
        },
        data: {
          label: "New Concept",
          frequency: 1,
          category: "detail",
          size: 1,
          color: "#96CEB4",
        },
        style: {
          background: "#96CEB4",
          width: "80px",
          height: "60px",
          fontSize: "12px",
        },
      };
      localNodes.value.push(newNode);
      saveChanges();
    };

    const deleteNode = (nodeId) => {
      if (confirm("Are you sure you want to delete this concept?")) {
        localNodes.value = localNodes.value.filter(
          (node) => node.id !== nodeId
        );
        localEdges.value = localEdges.value.filter(
          (edge) => edge.source !== nodeId && edge.target !== nodeId
        );
        saveChanges();
      }
    };

    const editNode = (node) => {
      editingNode.value = JSON.parse(JSON.stringify(node));
    };

    const saveNodeEdit = () => {
      const index = localNodes.value.findIndex(
        (n) => n.id === editingNode.value.id
      );
      if (index !== -1) {
        localNodes.value[index] = { ...editingNode.value };
      }
      closeModal();
      saveChanges();
    };

    // Edge operations
    const editEdge = (edge) => {
      editingEdge.value = JSON.parse(JSON.stringify(edge));
    };

    const saveEdgeEdit = () => {
      const index = localEdges.value.findIndex(
        (e) => e.id === editingEdge.value.id
      );
      if (index !== -1) {
        localEdges.value[index] = { ...editingEdge.value };
      }
      closeModal();
      saveChanges();
    };

    // Auto layout
    const autoLayout = () => {
      const cols = Math.ceil(Math.sqrt(localNodes.value.length));
      const nodeWidth = 100;
      const nodeHeight = 80;
      const spacing = 20;

      localNodes.value.forEach((node, index) => {
        const row = Math.floor(index / cols);
        const col = index % cols;
        node.position = {
          x: col * (nodeWidth + spacing) + 50,
          y: row * (nodeHeight + spacing) + 50,
        };
      });

      saveChanges();
    };

    // Save functionality
    const saveChanges = async () => {
      saving.value = true;
      statusText.value = "Saving...";

      try {
        const response = await axios.post(props.autosaveUrl, {
          nodes: localNodes.value,
          edges: localEdges.value,
        });

        // console.log('✅ Autosave successful:', response.data)
        statusText.value = "Saved";

        setTimeout(() => {
          statusText.value = "Ready";
        }, 2000);
      } catch (error) {
        console.error("❌ Error saving concept map:", error);
        statusText.value = "Save failed";
      } finally {
        saving.value = false;
      }
    };

    const saveMap = () => {
      saveChanges();
      alert("Concept map saved successfully!");
    };

    // Modal functions
    const closeModal = () => {
      editingNode.value = null;
      editingEdge.value = null;
    };

    return {
      localNodes,
      localEdges,
      editingNode,
      editingEdge,
      draggingNode,
      saving,
      statusText,
      canvas,
      canvasWidth,
      canvasHeight,
      getNodeCenter,
      startDrag,
      addNode,
      deleteNode,
      editNode,
      saveNodeEdit,
      editEdge,
      saveEdgeEdit,
      autoLayout,
      saveMap,
      closeModal,
    };
  },
};
</script>

<style scoped>
.concept-map-wrapper {
  position: relative;
  width: 100%;
  height: 600px;
  background: #f9fafb;
  border-radius: 8px;
  overflow: hidden;
}

.concept-map-toolbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  background: white;
  border-bottom: 1px solid #e5e7eb;
}

.concept-map-canvas {
  position: relative;
  width: 100%;
  height: calc(100% - 60px);
  overflow: auto;
}

.concept-node {
  position: absolute;
  border-radius: 8px;
  border: 2px solid white;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
    0 2px 4px -1px rgba(0, 0, 0, 0.06);
  cursor: move;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  transition: all 0.2s ease;
  user-select: none;
}

.concept-node:hover {
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
    0 4px 6px -2px rgba(0, 0, 0, 0.05);
  transform: translateY(-2px);
}

.concept-node.dragging {
  opacity: 0.8;
  z-index: 1000;
}

.node-label {
  color: white;
  font-weight: 600;
  font-size: inherit;
  line-height: 1.2;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.node-frequency {
  color: white;
  font-size: 10px;
  opacity: 0.8;
  margin-top: 2px;
}

.node-delete {
  position: absolute;
  top: -8px;
  right: -8px;
  background: #ef4444;
  color: white;
  border: none;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  font-size: 14px;
  line-height: 1;
  cursor: pointer;
  display: none;
  align-items: center;
  justify-content: center;
}

.concept-node:hover .node-delete {
  display: flex;
}

.edges-svg {
  position: absolute;
  top: 0;
  left: 0;
  pointer-events: none;
}

.edge-label {
  fill: #6b7280;
  font-size: 11px;
  font-weight: 500;
  pointer-events: all;
  cursor: pointer;
}

.edge-label:hover {
  fill: #374151;
}

.concept-map-status {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 16px;
  background: white;
  border-top: 1px solid #e5e7eb;
  font-size: 12px;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 24px;
  border-radius: 8px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
    0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.form-label {
  display: block;
  margin-bottom: 4px;
  font-weight: 500;
  color: #374151;
}

.form-input {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
}

.form-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-sm {
  padding: 6px 12px;
  font-size: 12px;
}

.empty-state {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  padding: 2rem;
}

.empty-icon {
  margin-bottom: 1rem;
}
</style>
