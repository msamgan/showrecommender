<x-public-layout>
    <section class="bg-gray-100 text-gray-800">
        <div
            class="container mx-auto flex flex-col items-center px-4 py-16 text-center md:px-10 md:py-32 lg:px-32 xl:max-w-6xl"
        >
            <h1 class="text-4xl font-bold leading-none sm:text-5xl">
                Discover Your Next
                <span class="text-orange-600">Favorite</span>
                Show
            </h1>

            <p class="mb-12 mt-8 px-8 text-lg">
                Enter up to three shows you love, and we'll find the perfect recommendations for you. Explore new genres
                and hidden gems tailored to your taste!
            </p>

            <div class="w-full max-w-xl rounded-2xl border border-orange-100 bg-white p-10 shadow-2xl">
                <livewire:searchshow />
            </div>

            <div class="mt-12 text-center">
                <p class="text-lg text-gray-800">
                    Not sure what to enter? Try popular shows like
                    <span class="font-semibold">Breaking Bad, Stranger Things, or The Office</span>
                    !
                </p>
            </div>
        </div>
    </section>
</x-public-layout>
