<?php

namespace Botble\Blog\Database\Traits;

use Botble\Blog\Models\Category;
use Botble\Blog\Models\Post;
use Botble\Blog\Models\Tag;
use Botble\Slug\Facades\SlugHelper;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait HasBlogSeeder
{
    protected function createBlogCategories(array $categories, bool $truncate = true): void
    {
        if ($truncate) {
            Category::query()->truncate();
        }

        $faker = $this->fake();

        foreach ($categories as $index => $item) {
            $item['description'] = $faker->text();
            $item['is_featured'] = ! isset($item['parent_id']) && $index != 0;

            $category = $this->createBlogCategory(Arr::except($item, 'children'), 0, $index != 0);

            if (Arr::has($item, 'children')) {
                foreach (Arr::get($item, 'children', []) as $child) {
                    $this->createBlogCategory($child, $category->getKey());
                }
            }
        }
    }

    protected function createBlogTags(array $tags, bool $truncate = true): void
    {
        if ($truncate) {
            Tag::query()->truncate();
        }

        foreach ($tags as $item) {
            $tag = Tag::query()->create($item);

            SlugHelper::createSlug($tag);
        }
    }

    protected function createBlogPosts(array $posts, bool $truncate = true): void
    {
        if ($truncate) {
            Post::query()->truncate();
            DB::table('post_categories')->truncate();
            DB::table('post_tags')->truncate();
        }

        $faker = $this->fake();

        $categoryIds = Category::query()->pluck('id');
        $tagIds = Tag::query()->pluck('id');

        foreach ($posts as $item) {
            $item['views'] = $faker->numberBetween(100, 2500);

            if (! isset($item['description'])) {
                $item['description'] = $faker->realText();
            }

            if ($item['content']) {
                $item['content'] = $this->removeBaseUrlFromString($item['content']);
            }

            /**
             * @var Post $post
             */
            $post = Post::query()->create($item);

            $post->categories()->sync(array_unique([
                $categoryIds->random(),
                $categoryIds->random(),
            ]));

            $post->tags()->sync(array_unique([
                $tagIds->random(),
                $tagIds->random(),
                $tagIds->random(),
            ]));

            SlugHelper::createSlug($post);
        }
    }

    protected function getCategoryId(string $name): int|string
    {
        return Category::query()->where('name', $name)->value('id');
    }

    protected function createBlogCategory(array $item, int $parentId = 0, bool $isFeatured = false): Category
    {
        $category = Category::query()->create(array_merge($item, [
            'description' => $this->fake()->text(),
            'author_id' => 1,
            'parent_id' => $parentId,
            'is_featured' => $isFeatured,
        ]));

        Slug::query()->create([
            'reference_type' => Category::class,
            'reference_id' => $category->id,
            'key' => Str::slug($category->name),
            'prefix' => SlugHelper::getPrefix(Category::class),
        ]);

        return $category;
    }
}
