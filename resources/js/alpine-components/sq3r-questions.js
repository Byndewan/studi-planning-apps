export default function () {
  return {
    questions: ['', '', ''],

    init() {
      const old = window._oldQuestions ?? ['', '', ''];
      this.questions = Array.isArray(old) ? old : ['', '', ''];
    },

    addQuestion() {
      this.questions.push('');
    },

    removeQuestion(index) {
      if (this.questions.length > 1) {
        this.questions.splice(index, 1);
      }
    }
  };
}
