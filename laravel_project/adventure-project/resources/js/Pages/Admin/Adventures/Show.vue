<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { 
    ArrowLeftIcon, 
    PencilSquareIcon, 
    TrashIcon, 
    MapPinIcon, 
    ClockIcon, 
    UsersIcon, 
    BanknotesIcon,
    TagIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
    adventure: Object
})

const deleteAdventure = (id) => {
    if (confirm('Are you sure you want to delete this adventure? This action cannot be undone.')) {
        router.delete(route('admin.adventures.destroy', id))
    }
}
</script>

<template>
    <AdminLayout>
        <div class="max-w-5xl mx-auto px-6 py-12 md:py-16">
            
            <!-- Top Navigation & Actions Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
                <Link 
                    :href="route('admin.adventures.index')" 
                    class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-green-700 bg-white border border-slate-200 px-4 py-2.5 rounded-xl shadow-sm transition w-fit"
                >
                    <ArrowLeftIcon class="w-4 h-4" /> Back to Adventures
                </Link>

                <div class="flex items-center gap-3">
                    <Link 
                        :href="route('admin.adventures.edit', adventure.id)" 
                        class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold px-5 py-2.5 rounded-xl transition shadow-sm text-sm"
                    >
                        <PencilSquareIcon class="w-4 h-4" /> Edit Package
                    </Link>

                    <button 
                        @click="deleteAdventure(adventure.id)"
                        class="inline-flex items-center gap-2 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold px-5 py-2.5 rounded-xl transition text-sm shadow-sm border border-rose-100"
                    >
                        <TrashIcon class="w-4 h-4" /> Delete
                    </button>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                
                <!-- Hero Image Display -->
                <div class="relative w-full h-[380px] bg-slate-100">
                    <img 
                        v-if="adventure.image" 
                        :src="'/storage/' + adventure.image" 
                        :alt="adventure.title" 
                        class="w-full h-full object-cover"
                    />
                    <div v-else class="w-full h-full flex items-center justify-center text-7xl bg-green-50 text-green-700">
                        🏔️
                    </div>

                    <!-- Category Pill Overlay -->
                    <div class="absolute top-6 left-6">
                        <span class="inline-flex items-center gap-1.5 bg-white/90 backdrop-blur-md text-green-800 font-bold px-4 py-1.5 rounded-full text-xs shadow-lg uppercase tracking-wider">
                            <TagIcon class="w-3.5 h-3.5 text-green-700" /> {{ adventure.category?.name || 'General' }}
                        </span>
                    </div>
                </div>

                <!-- Body Details -->
                <div class="p-8 md:p-10 space-y-8">
                    
                    <div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
                            {{ adventure.title }}
                        </h1>
                        <p class="text-slate-500 flex items-center gap-1.5 text-sm mt-2">
                            <MapPinIcon class="w-4 h-4 text-green-600" /> {{ adventure.location }}
                        </p>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Price</span>
                            <span class="text-2xl font-extrabold text-green-700 flex items-center gap-1">
                                RM {{ adventure.price }}
                            </span>
                        </div>

                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Duration</span>
                            <span class="text-lg font-bold text-slate-800 flex items-center gap-1.5">
                                <ClockIcon class="w-5 h-5 text-slate-400" /> {{ adventure.duration }} Days
                            </span>
                        </div>

                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Max Group Size</span>
                            <span class="text-lg font-bold text-slate-800 flex items-center gap-1.5">
                                <UsersIcon class="w-5 h-5 text-slate-400" /> {{ adventure.max_people }} People
                            </span>
                        </div>

                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Difficulty</span>
                            <span class="inline-block font-bold text-xs px-3 py-1 rounded-full uppercase tracking-wider mt-0.5"
                                :class="{
                                    'bg-emerald-100 text-emerald-800': adventure.difficulty === 'Easy',
                                    'bg-amber-100 text-amber-800': adventure.difficulty === 'Moderate',
                                    'bg-rose-100 text-rose-800': adventure.difficulty === 'Hard' || adventure.difficulty === 'Extreme',
                                }"
                            >
                                {{ adventure.difficulty }}
                            </span>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="space-y-3 pt-4 border-t border-slate-100">
                        <h2 class="text-xl font-bold text-slate-900">Adventure Overview</h2>
                        <p class="text-slate-600 leading-relaxed whitespace-pre-line text-base">
                            {{ adventure.description }}
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </AdminLayout>
</template>
