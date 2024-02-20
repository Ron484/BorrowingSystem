<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $categories = [
            'Romance' => [
                'title' => "Outlander",
                'description' => "A historical romance novel by Diana Gabaldon that follows the story of Claire Randall, a married former nurse who is mysteriously transported back in time to 1743 Scotland.",
                'author' => "Diana Gabaldon",
                'publisher' => "Doubleday",
                'pages' => 850,
            ],
            'Fantasy' => [
                'title' => "Harry Potter and the Sorcerer's Stone",
                'description' => "The first book in the Harry Potter series by J.K. Rowling that follows the story of a young wizard, Harry Potter, and his adventures at Hogwarts School of Witchcraft and Wizardry.",
                'author' => "J.K. Rowling",
                'publisher' => "Bloomsbury",
                'pages' => 309,
            ],
            'History' => [
                'title' => "Guns, Germs, and Steel: The Fates of Human Societies",
                'description' => "A book by Jared Diamond that explores the reasons why some societies developed more quickly than others.",
                'author' => "Jared Diamond",
                'publisher' => "W. W. Norton & Company",
                'pages' => 480,
            ],
            'Science' => [
                'title' => "The Selfish Gene",
                'description' => "A book by Richard Dawkins that introduces the concept of the gene-centered view of evolution.",
                'author' => "Richard Dawkins",
                'publisher' => "Oxford University Press",
                'pages' => 360,
            ],
            'Technology' => [
                'title' => "Steve Jobs",
                'description' => "A biography of Steve Jobs by Walter Isaacson that explores the life and career of the co-founder of Apple Inc.",
                'author' => "Walter Isaacson",
                'publisher' => "Simon & Schuster",
                'pages' => 656,
            ],
            'Art' => [
                'title' => "Ways of Seeing",
                'description' => "A book by John Berger that discusses the relationship between seeing and the wider cultural, political, and social contexts.",
                'author' => "John Berger",
                'publisher' => "Penguin Books",
                'pages' => 166,
            ],
            'Philosophy' => [
                'title' => "Beyond Good and Evil",
                'description' => "A book by Friedrich Nietzsche that challenges traditional notions of morality.",
                'author' => "Friedrich Nietzsche",
                'publisher' => "C. G. Naumann",
                'pages' => 240,
            ],
            'Poetry' => [
                'title' => "The Waste Land",
                'description' => "A poem by T.S. Eliot that is considered one of the most important poems of the 20th century.",
                'author' => "T.S. Eliot",
                'publisher' => "Faber & Faber",
                'pages' => null, // Varies (multiple editions)
            ],
            'Drama' => [
                'title' => "Death of a Salesman",
                'description' => "A play by Arthur Miller that explores the themes of success, failure, and the American Dream.",
                'author' => "Arthur Miller",
                'publisher' => "Penguin Books",
                'pages' => null, // Varies (multiple editions)
            ],
            'Health' => [
                'title' => "Born to Run: A Hidden Tribe, Superathletes, and the Greatest Race the World Has Never Seen",
                'description' => "A book by Christopher McDougall that explores the secrets of the Tarahumara Indians and their ability to run long distances with ease.",
                'author' => "Christopher McDougall",
                'publisher' => "Alfred A. Knopf",
                'pages' => 287,
            ],
            'Cooking' => [
                'title' => "Salt, Fat, Acid, Heat: Mastering the Elements of Good Cooking",
                'description' => "A cookbook by Samin Nosrat that explains the fundamental principles of cooking and how to use them to become a better cook.",
                'author' => "Samin Nosrat",
                'publisher' => "Simon & Schuster",
                'pages' => 473,
            ],
        ];

        $categoryName = $this->faker->randomElement(array_keys($categories));
        $category = Category::where('name', $categoryName)->first();

        return [
            'category_id' => $category->id,
            'title' => $categories[$categoryName]['title'],
            'description' => $categories[$categoryName]['description'],
            'author' => $categories[$categoryName]['author'],
            'publisher' => $categories[$categoryName]['publisher'],
            'pages' => $categories[$categoryName]['pages'],
            'image' => $this->faker->imageUrl(),
            'status' => 1,
        ];

    }
}