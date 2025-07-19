<!-- File: components/WysiwygEditor.vue -->
<template>
  <div class="max-w-4xl mx-auto p-4">
    <div class="bg-white rounded-xl shadow-md border border-gray-200">
      <div class="flex flex-wrap items-center gap-2 border-b px-4 py-2 bg-gray-50">
        <button
          v-for="btn in toolbar"
          :key="btn.title"
          @click="btn.action"
          :title="btn.title"
          class="p-2 rounded hover:bg-gray-200"
        >
          <component :is="btn.icon" class="w-5 h-5" />
        </button>
        <input
          type="file"
          accept="image/*"
          @change="handleImageUpload"
          class="hidden"
          ref="fileInput"
        />
      </div>

      <EditorContent
        :editor="editor"
        class="prose max-w-none px-4 py-4 min-h-[200px] focus:outline-none"
      />

      <div class="px-4 py-2 border-t flex justify-between items-center">
        <button
          @click="emitContent"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Save
        </button>
        <button
          @click="togglePreview"
          class="text-sm text-gray-600 hover:underline"
        >
          {{ showPreview ? 'Hide' : 'Show' }} Preview
        </button>
      </div>
    </div>

    <div
      v-if="showPreview"
      class="mt-4 p-4 bg-white border rounded shadow-sm"
    >
      <h3 class="text-lg font-semibold mb-2">Live Preview</h3>
      <div v-html="editor.getHTML()" class="prose max-w-none"></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onBeforeUnmount } from 'vue';
import { Editor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import Link from '@tiptap/extension-link';
import { Node, mergeAttributes } from '@tiptap/core';

import {
  Bold, Italic, Underline as UnderlineIcon, Strikethrough, Quote,
  List, ListOrdered, Heading1, Heading2, Heading3, Heading4,
  Undo2, Redo2, Link2, ImageIcon, Code2, Youtube
} from 'lucide-vue-next';

const content = ref('');
const showPreview = ref(false);
const fileInput = ref(null);

// ✅ Custom ResizableImage Node
const ResizableImage = Node.create({
  name: 'resizableImage',
  group: 'inline',
  inline: true,
  atom: true,
  draggable: true,

  addAttributes() {
    return {
      src: { default: null },
      width: { default: 'auto' },
    };
  },

  parseHTML() {
    return [{ tag: 'img[src]' }];
  },

  renderHTML({ HTMLAttributes }) {
    return ['img', mergeAttributes(HTMLAttributes)];
  },

  addCommands() {
    return {
      setResizableImage:
        (attrs) =>
        ({ commands }) => {
          return commands.insertContent({
            type: this.name,
            attrs,
          });
        },
    };
  },

  addNodeView() {
    return ({ node, getPos, editor }) => {
      const container = document.createElement('span');
      container.style.position = 'relative';
      container.style.display = 'inline-block';

      const img = document.createElement('img');
      img.src = node.attrs.src;
      img.style.width = node.attrs.width || 'auto';
      img.style.display = 'block';
      img.style.maxWidth = '100%';

      const handle = document.createElement('div');
      handle.style.position = 'absolute';
      handle.style.right = '0';
      handle.style.bottom = '0';
      handle.style.width = '12px';
      handle.style.height = '12px';
      handle.style.background = 'blue';
      handle.style.cursor = 'nwse-resize';
      handle.style.borderRadius = '50%';

      handle.addEventListener('mousedown', (e) => {
        e.preventDefault();
        const startX = e.clientX;
        const startWidth = img.offsetWidth;

        const onMouseMove = (moveEvent) => {
          const newWidth = startWidth + (moveEvent.clientX - startX);
          img.style.width = `${newWidth}px`;
        };

        const onMouseUp = () => {
          document.removeEventListener('mousemove', onMouseMove);
          document.removeEventListener('mouseup', onMouseUp);

          editor.commands.command(({ tr }) => {
            tr.setNodeMarkup(getPos(), undefined, {
              ...node.attrs,
              width: img.style.width,
            });
            return true;
          });
        };

        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
      });

      container.appendChild(img);
      container.appendChild(handle);

      return {
        dom: container,
      };
    };
  },
});

// ✅ YouTube Embed Node
const Embed = Node.create({
  name: 'embed',
  group: 'block',
  atom: true,
  selectable: true,

  addAttributes() {
    return {
      src: { default: null },
    };
  },

  parseHTML() {
    return [{ tag: 'iframe[src]' }];
  },

  renderHTML({ HTMLAttributes }) {
    return [
      'iframe',
      mergeAttributes(HTMLAttributes, {
        class: 'w-full aspect-video border rounded',
        frameborder: '0',
        allowfullscreen: 'true',
      }),
    ];
  },

  addCommands() {
    return {
      setEmbed:
        (attrs) =>
        ({ commands }) => {
          return commands.insertContent({
            type: this.name,
            attrs,
          });
        },
    };
  },
});

const editor = new Editor({
  content: '',
  extensions: [
    StarterKit,
    Underline,
    Link.configure({ openOnClick: false }),
    ResizableImage,
    Embed,
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

const handleImageUpload = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = () => {
    editor.chain().focus().setResizableImage({ src: reader.result }).run();
  };
  reader.readAsDataURL(file);
};

const getYouTubeEmbedUrl = (url) => {
  const match = url.match(
    /(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/
  );
  return match?.[1] ? `https://www.youtube.com/embed/${match[1]}` : null;
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
  {
    title: 'Link',
    icon: Link2,
    action: () => {
      const url = prompt('Enter URL');
      if (url) editor.chain().focus().setLink({ href: url }).run();
    },
  },
  {
    title: 'Insert Image',
    icon: ImageIcon,
    action: () => fileInput.value.click(),
  },
  {
    title: 'Code Block',
    icon: Code2,
    action: () => editor.chain().focus().toggleCodeBlock().run(),
  },
  {
    title: 'Embed YouTube',
    icon: Youtube,
    action: () => {
      const url = prompt('Paste YouTube video URL');
      const embedUrl = getYouTubeEmbedUrl(url);
      if (embedUrl) {
        editor.chain().focus().setEmbed({ src: embedUrl }).run();
      } else {
        alert('Invalid YouTube URL.');
      }
    },
  },
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
