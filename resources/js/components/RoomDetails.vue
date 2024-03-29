<template>
  <div>
    <div class="flex items-center">
      <h1 class="text-3xl font-semibold">{{ room.number }}</h1>
      <toggled-chip
        class="ml-4"
        :toggled="room.available === 1"
        active="Available"
        inactive="Unavailable"
      ></toggled-chip>
    </div>
    <div class="text-gray-400 text-sm font-medium my-2 flex items-center">
      <i class="lni lni-map-marker mr-2"></i>
      {{ room.location }}, Floor {{ room.floor }}
    </div>
    <hr class="mt-8 mb-4" />
    <h3 class="text-xl font-medium mb-2">Contract</h3>
    <div>
      Available on
      <b>{{ room.long_contract ? "Long or Short" : "Short" }}</b> contract.
      <br />
      Band {{ room.band }}:
      <b>{{
        `£${room.short_rent}${
          room.long_contract ? " / £" + room.long_rent : ""
        }`
      }}</b>
      <span v-if="!!room.notes">
        <br/>
        Note: <b>{{room.notes}}</b>
      </span>
    </div>
    <h3 class="text-xl font-medium mt-4">Photos</h3>
    <div class="flex flex-wrap -mx-3">
      <img
        @click="openModal(img)"
        v-for="(img, i) in room.images"
        :key="i"
        :src="img"
        class="rounded-xl shadow-sm transition-shadow duration-150 hover:shadow-md m-3 flex-auto h-36 w-36 object-cover cursor-pointer"
      />
      <image-dropper class="w-36 flex-auto" :loading="imgUploading" @input="uploadImages($event)"></image-dropper>
    </div>
    <h3 class="text-xl font-medium mt-4">Key Features</h3>
    <div
      class="grid grid-cols-3 gap-3 rounded-md shadow-inner bg-gray-100 mt-3 p-3 mb-6"
    >
      <div
        v-for="perk in room.perks"
        :key="perk.id"
        class="rounded-lg shadow inline-flex items-center bg-white text-center p-2 font-medium text-sm"
      >
        <i class="material-icons-round text-2xl text-purple-900">{{
          perk.icon
        }}</i>
        <span class="flex-grow text-center">{{ perk.name | prettify }}</span>
      </div>
    </div>
    <h3 class="text-xl font-medium mt-4 mb-2">Comments</h3>
    <div
      v-for="(comment, j) in room.comments"
      :key="`c-${room.id}-${comment.id}`"
    >
      <hr v-if="j !== 0" class="my-2" />
      <div class="flex items-start">
        <div
          class="bg-purple-800 text-white text-md font-bold mt-1 px-1.5 py0.5 rounded-md"
        >
          {{ comment.user.name && comment.user.name[0] }}
        </div>
        <div class="ml-2">
          <!-- <div class="font-medium text-black text-sm">
            {{ comment.user.name }}
          </div> -->
          <div class="text-black text-sm whitespace-pre-line">{{ comment.text }}</div>
          <div class="text-xs text-gray-500">
            {{ comment.user.name }}, {{ comment.created_at | commentDate }}
          </div>
        </div>
      </div>
    </div>
    <div class="mt-4 mb-6">
      <textarea-autosize
        maxlength="1000"
        @keydown.left.native.stop
        @keydown.right.native.stop
        @keydown.esc.native.stop
        id="comment"
        name="comment"
        v-model="comment"
        rows="1"
        class="shadow-sm focus:ring-2 ring-1 outline-none focus:ring-purple-500 focus:border-purple-500 mt-1 p-3 w-full sm:text-sm ring-gray-300 rounded-md"
        placeholder="Leave a comment..."
      ></textarea-autosize>
      <button
        @click="postComment()"
        :disabled="loading || comment.length < 5"
        class="text-white inline-block py-2 px-2 transition-colors duration-150 mt-2 rounded-md text-sm font-medium"
        :class="
          loading || comment.length < 5
            ? 'bg-gray-400'
            : 'bg-purple-600 hover:bg-purple-800'
        "
      >
        Submit
      </button>
    </div>
  </div>
</template>

<script>
import EventBus from '~/services/EventBus';
import ToggledChip from "./ToggledChip";
import moment from "moment";
import ImageDropper from './ImageDropper.vue';

export default {
  props: {
    room: Object,
  },
  filters: {
    prettify(perk) {
      return perk
        .split("_")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
    },
    commentDate(date) {
      return moment(date).fromNow();
    },
  },
  created() {
    EventBus.$on('nextImg', src => {
      let prev = this.room.images.indexOf(src);
      if (prev > -1 && prev < this.room.images.length - 1) {
        EventBus.$emit('openModal', this.room.images[prev + 1]);
      }
    });
    EventBus.$on('prevImg', src => {
      let prev = this.room.images.indexOf(src);
      if (prev > 0) {
        EventBus.$emit('openModal', this.room.images[prev - 1]);
      }
    });
  },
  data() {
    return {
      comment: "",
      loading: false,
      imgUploading: false,
    };
  },
  computed: {
    perks() {
      return this.room.perks.map(prettify);
    },
  },
  methods: {
    postComment() {
      this.loading = true;
      window.api
        .post("/comments", {
          text: this.comment,
          room_id: this.room.id,
        })
        .then(({ data }) => {
          this.$emit("comment", data);
          this.loading = false;
          this.comment = "";
        })
        .catch((err) => {
          // TODO: handle
        });
    },
    openModal(img) {
      EventBus.$emit('openModal', img);
    },
    uploadImages(files) {
      this.imgUploading = true;
      Promise.all(files.map(file => {
        let data = new FormData();
        data.append('room_id', this.room.id);
        data.append('image', file);
        return window.api.post('/images', data, {
          headers: { "Content-Type": "multipart/form-data" }
        });
      })).then(results => {
        this.imgUploading = false;
        results.forEach(({data}) => {
          this.room.images.push(data.filename);
        });
      }).catch(err => {
        this.imgUploading = false;
      });
    }
  },
  components: { ToggledChip, ImageDropper },
};
</script>