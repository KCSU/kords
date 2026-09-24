// Vue 3 dropped `new Vue()` as an event bus; this keeps the same $on/$emit calls.
const handlers = {};

export default {
    $on(event, handler) {
        (handlers[event] ||= []).push(handler);
    },
    $emit(event, payload) {
        (handlers[event] || []).forEach(handler => handler(payload));
    }
};
