@extends('layouts.app')

@section('title', "List meetings")

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item active">Meetings</li>--}}
        {{--</ol>--}}

        @can('create', [\App\Meeting::class, $group])
            <a href="{{ route('groups.meetings.create', $group->slug) }}" class="btn btn-primary pull-right">
                <i class="fa fa-plus"></i>
                Schedule meeting
            </a>
        @endcan

        <h1>Meetings</h1>

        @if ($meetings->count())
            <table class="table">
                <tr>
                    <th>Subject</th>
                    <th>Begins</th>
                    <th>Ends</th>
                    <th>Participants</th>
                    <th>&nbsp;</th>
                </tr>
                @foreach ($meetings as $meeting)
                    <tr>
                        <td>
                            <a href="{{ route('groups.meetings.show', [$group->slug, $meeting->id]) }}">
                                {{ $meeting->subject }}
                            </a>
                        </td>
                        <td>
                            <date-format value="{{ $meeting->starts_at->toIso8601String() }}"></date-format>
                        </td>
                        <td>
                            <date-format value="{{ $meeting->ends_at->toIso8601String() }}"></date-format>
                        </td>
                        <td>
                            {{ $meeting->active_participants_count }} / {{ $meeting->total_participants_count }}
                        </td>
                        <td class="text-right">
                            @can('update', $meeting)
                                <a href="{{ route('meetings.agendas.index', [$meeting->id]) }}"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="fa fa-sitemap"></i>
                                </a>

                                <a href="{{ route('groups.meetings.edit', [$group->slug, $meeting->id]) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan

                            @can('delete', $meeting)
                                <delete-record-button
                                        action="{{ route('groups.meetings.destroy', [$group->slug, $meeting->id]) }}">
                                    <button type="button" class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </delete-record-button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </table>

            {{ $meetings->links() }}
        @else
            <p>You currently don't have any meetings scheduled.</p>
        @endif
    </div>
@endsection