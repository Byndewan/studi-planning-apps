@if ($conceptMaps->isEmpty())
    <div class="md:col-span-3 card card-hover">
        <div class="empty-state py-16">
            <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                <i class="fas fa-project-diagram text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada peta konsep</h3>
            <p class="text-gray-600 mb-6">Visualisasikan pengetahuan Anda dengan membuat peta konsep pertama</p>
            <a href="{{ route('concept-maps.create') }}" class="btn-primary">Peta Konsep Baru</a>
        </div>
    </div>
@else
    @foreach ($conceptMaps as $map)
        @include('concept-maps.partials.concept-map-card', ['map' => $map])
    @endforeach
@endif
