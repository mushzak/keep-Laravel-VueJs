<engagement-chart
        :discussions="{{ $member->discussionsSent->load('author.user')->toJson() }}"
        :members="{{ $group->members->load('user')->toJson() }}" :graph_only="{{ $graph_only ? 'true' : 'false' }}"
        :colors="['#80bf8e','#b7c1b9']"></engagement-chart>