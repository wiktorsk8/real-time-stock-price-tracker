<template>
  <div class="flex bg-neutral-800 h-screen">
    <!-- Left Column (Empty or Future Use) -->
    <div class="w-1/4 bg-neutral-800 p-4 hidden md:block">
      <!-- Add content here if needed -->
    </div>

    <!-- Middle Column (Main BTC Price Display) -->
    <div class="w-full md:w-1/2 flex flex-col items-center justify-center">
      <h1 :style="{ color: tradeColor }" class="text-5xl font-bold">
        {{ currentTrade?.symbol }}: {{ currentTrade?.price }}
      </h1>

      <div class="mt-4 flex space-x-2">
        <input type="number" v-model="rate" placeholder="Enter new rate" class="border p-2 rounded" />
        <button @click="sendRate" class="bg-blue-500 text-white p-2 rounded">Change update rate</button>
      </div>
    </div>

    <!-- Right Column (Real-Time Trade Data) -->
    <div class="w-1/4 bg-neutral-700 overflow-y-auto" ref="tradeContainer">
      <div class="sticky top-0 bg-neutral-700 z-10 pb-2">
        <h2 class="text-xl font-semibold">Recent Trades</h2>
      </div>
      <ul>
        <li
            v-for="(trade, index) in trades"
            :key="trade.tradeId"
            class="p-2 border-b"
            :style="{ color: getTradeColor(index) }"
        >
          #{{ index + 1 }} | {{ trade.symbol }}: {{ trade.price }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import {ref, computed, watch, nextTick, reactive} from 'vue'
import {router} from "@inertiajs/vue3";

const eventSource = new EventSource('/stockData');

const rate = ref(null);

function sendRate() {
  axios.post('/updateStockRate', { rate: rate.value })
      .then(response => {
        alert("Stock update rate has been changed.");
      })
      .catch(error => {
        console.error('Error:', error.response?.data || error.message);
      });
}

class TradeDTO {
  constructor(payload) {
    this.eventType = payload.e;
    this.eventTime = new Date(payload.E);
    this.symbol = payload.s;
    this.tradeId = payload.t;
    this.price = parseFloat(payload.p);
    this.quantity = parseFloat(payload.q);
    this.tradeTime = new Date(payload.T);
    this.isBuyerMarketMaker = payload.m;
    this.isBestMatch = payload.M;
  }
}

const trades = ref([]);

function addTrade(payload) {
  const trade = new TradeDTO(payload);
  trades.value.push(trade);
  console.log("New trade added:", trade);
}

eventSource.onmessage = function (event) {
  addTrade(JSON.parse(event.data));
};

const currentTrade = computed(() => trades.value.length ? trades.value[trades.value.length - 1] : null);
const previousTrade = computed(() => trades.value.length >= 2 ? trades.value[trades.value.length - 2] : null);

const tradeColor = computed(() => {
  if (!currentTrade.value) return 'black';
  if (!previousTrade.value) return 'green';

  const currentPrice = parseFloat(currentTrade.value.price.toFixed(5));
  const prevPrice = parseFloat(previousTrade.value.price.toFixed(5));

  return currentPrice > prevPrice ? 'green' : currentPrice < prevPrice ? 'red' : 'white';
});

const getTradeColor = (index) => {
  if (index === 0) return 'green';
  const currentPrice = parseFloat(trades.value[index].price.toFixed(5));
  const prevPrice = parseFloat(trades.value[index - 1]?.price?.toFixed(5) || currentPrice);

  return currentPrice > prevPrice ? 'green' : currentPrice < prevPrice ? 'red' : 'white';
};

// Ref for the container that holds the trade list
const tradeContainer = ref(null);

// Watch the trades array and auto-scroll to the bottom when new trade data is added.
watch(trades, async () => {
  await nextTick(); // Wait for DOM update
  if (tradeContainer.value) {
    tradeContainer.value.scrollTop = tradeContainer.value.scrollHeight;
  }
}, { deep: true });
</script>

<style scoped>
/* Tailwind CSS is used, so no extra CSS is required here */
</style>
