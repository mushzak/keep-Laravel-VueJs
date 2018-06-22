@extends('layouts.app')

@section('title', "List channels")

@section('content')
    <div class="container">
        @can('facilitate', $group)
            <a href="{{ route('groups.channels.create', $group->slug) }}" class="btn btn-primary pull-right">
                <i class="fa fa-plus"></i>
                Create a channel
            </a>
        @endcan

        <h1>Channels</h1>

        @if ($channels->count())
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Messages</th>
                    <th>Created on</th>
                    <th>&nbsp;</th>
                </tr>
                @foreach ($channels as $channel)
                    <tr>
                        <td>
                            <a href="{{ route('groups.channels.show', [$group->slug, $channel->id]) }}">
                                {{ $channel->name }}
                            </a>

                            @if ($channel->is_archived)
                                <span>(archived)</span>
                            @endif
                        </td>
                        <td>
                            {{ $channel->messages_count }}
                        </td>
                        <td>
                            <date-format value="{{ $channel->created_at->toIso8601String() }}"></date-format>
                        </td>
                        <td class="text-right">
                            @can('facilitate', $group)
                                <a href="{{ route('groups.channels.edit', [$group->slug, $channel->id]) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <delete-record-button
                                        action="{{ route('groups.channels.destroy', [$group->slug, $channel->id]) }}">
                                    <button type="button" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </delete-record-button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </table>

            {{ $channels->links() }}
        @else
            <p>There are currently no channels to join.</p>
        @endif

        <h2>Private message</h2>
        <ul>
            @foreach ($members as $member)
                <li>
                    <a href="#!">
                        {{ $member->user->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection