<?php

namespace App\Repositories\Contracts;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;

/**
 * Interface PostRepository.
 */
interface PostRepository extends BaseRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function published();

    /**
     * @return mixed
     */
    public function publishedByTag(Tag $tag);

    /**
     * @return mixed
     *
     * @internal param \App\Models\Tag $tag
     */
    public function publishedByOwner(User $user);

    /**
     * @param string $slug
     *
     * @return Post
     */
    public function findBySlug($slug);

    /**
     * @param \Illuminate\Http\UploadedFile $image
     *
     * @return mixed
     */
    public function saveAndPublish(Post $post, array $input, UploadedFile $image = null);

    /**
     * @param \Illuminate\Http\UploadedFile $image
     *
     * @return mixed
     */
    public function saveAsDraft(Post $post, array $input, UploadedFile $image = null);

    /**
     * @return mixed
     */
    public function destroy(Post $post);

    /**
     * @return mixed
     */
    public function batchDestroy(array $ids);

    /**
     * @return mixed
     */
    public function batchPublish(array $ids);

    /**
     * @return mixed
     */
    public function batchPromote(array $ids);

    /**
     * @return mixed
     */
    public function batchPin(array $ids);
}
