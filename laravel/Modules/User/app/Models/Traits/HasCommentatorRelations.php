<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Comment\Datas\CommentConfigData;
use Modules\Comment\Models\Comment;
use Modules\Comment\Models\CommentNotificationSubscription;
use Modules\Comment\Models\Reaction;

trait HasCommentatorRelations
{
    /**
     * @return MorphMany<Comment, $this>
     */
    public function commentatorComments(): MorphMany
    {
        /** @var class-string<Comment> $commentClass */
        $commentClass = CommentConfigData::make()->models['comment'];

        return $this->morphMany($commentClass, 'commentator');
    }

    /**
     * @return MorphMany<CommentNotificationSubscription, $this>
     */
    public function subscriberNotificationSubscriptions(): MorphMany
    {
        /** @var class-string<CommentNotificationSubscription> $subscriptionClass */
        $subscriptionClass = CommentConfigData::make()->models['comment_notification_subscription'];

        return $this->morphMany($subscriptionClass, 'subscriber');
    }

    /**
     * @return MorphMany<Reaction, $this>
     */
    public function reactions(): MorphMany
    {
        /** @var class-string<Reaction> $reactionClass */
        $reactionClass = CommentConfigData::make()->models['reaction'];

        return $this->morphMany($reactionClass, 'commentator');
    }
}
