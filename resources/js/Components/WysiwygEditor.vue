// File: components/WysiwygEditor.vue
<template>
  <div class="max-w-4xl mx-auto p-4">
    <div class="bg-white rounded-xl shadow-md border border-gray-200">
      <div class="flex flex-wrap items-center gap-2 border-b px-4 py-2 bg-gray-50">
        <button v-for="btn in toolbar" :key="btn.title" @click="btn.action" :title="btn.title" class="p-2 rounded hover:bg-gray-200">
          <component :is="btn.icon" class="w-5 h-5" />
        </button>
        <input type="file" accept="image/*" @change="handleImageUpload" class="hidden" ref="fileInput" />
      </div>
      <EditorContent :editor="editor" class="prose max-w-none px-4 py-4 min-h-[200px] focus:outline-none" />
      <div class="px-4 py-2 border-t flex justify-between items-center">
        <button @click="emitContent" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Save
        </button>
        <button @click="togglePreview" class="text-sm text-gray-600 hover:underline">
          {{ showPreview ? 'Hide' : 'Show' }} Preview
        </button>
      </div>
    </div>
    <div v-if="showPreview" class="mt-4 p-4 bg-white border rounded shadow-sm">
      <h3 class="text-lg font-semibold mb-2">Live Preview</h3>
      <div v-html="editor.getHTML()" class="prose max-w-none"></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Editor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import Link from '@tiptap/extension-link';
import Image from '@tiptap/extension-image';

import { Bold, Italic, Underline as UnderlineIcon, Strikethrough, Quote, List, ListOrdered, Heading1, Heading2, Heading3, Heading4, Undo2, Redo2, Link2, ImageIcon, Code2 } from 'lucide-vue-next';

const content = ref('');
const showPreview = ref(false);
const fileInput = ref(null);

const editor = new Editor({
  content: '',
  extensions: [
    StarterKit,
    Underline,
    Link.configure({ openOnClick: false }),
    Image
  ],
  onUpdate({ editor }) {
    content.value = editor.getHTML();
  },
});

const emitContent = () => {
  console.log(content.value);
};

const togglePreview = () => {
  showPreview.value = !showPreview.value;
};

const handleImageUpload = async (e) => {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = () => {
    editor.chain().focus().setImage({ src: reader.result }).run();
  };
  reader.readAsDataURL(file);
};

const toolbar = [
  { title: 'Bold', icon: Bold, action: () => editor.chain().focus().toggleBold().run() },
  { title: 'Italic', icon: Italic, action: () => editor.chain().focus().toggleItalic().run() },
  { title: 'Underline', icon: UnderlineIcon, action: () => editor.chain().focus().toggleUnderline().run() },
  { title: 'Strikethrough', icon: Strikethrough, action: () => editor.chain().focus().toggleStrike().run() },
  { title: 'Heading 1', icon: Heading1, action: () => editor.chain().focus().toggleHeading({ level: 1 }).run() },
  { title: 'Heading 2', icon: Heading2, action: () => editor.chain().focus().toggleHeading({ level: 2 }).run() },
  { title: 'Heading 3', icon: Heading3, action: () => editor.chain().focus().toggleHeading({ level: 3 }).run() },
  { title: 'Heading 4', icon: Heading4, action: () => editor.chain().focus().toggleHeading({ level: 4 }).run() },
  { title: 'Blockquote', icon: Quote, action: () => editor.chain().focus().toggleBlockquote().run() },
  { title: 'Bullet List', icon: List, action: () => editor.chain().focus().toggleBulletList().run() },
  { title: 'Ordered List', icon: ListOrdered, action: () => editor.chain().focus().toggleOrderedList().run() },
  { title: 'Link', icon: Link2, action: () => {
    const url = prompt('Enter URL');
    if (url) editor.chain().focus().setLink({ href: url }).run();
  }},
  { title: 'Insert Image', icon: ImageIcon, action: () => fileInput.value.click() },
  { title: 'Code Block', icon: Code2, action: () => editor.chain().focus().toggleCodeBlock().run() },
  { title: 'Undo', icon: Undo2, action: () => editor.chain().focus().undo().run() },
  { title: 'Redo', icon: Redo2, action: () => editor.chain().focus().redo().run() },
];

onBeforeUnmount(() => {
  editor.destroy();
});
</script>

<style scoped>
button[title] {
  transition: background-color 0.2s ease;
}
</style>
