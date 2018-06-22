@extends('layouts.app')

@section('title', 'List agenda')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.meetings.index', $group->slug) }}">Meetings</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.meetings.show', [$group->slug, $meeting->id]) }}">{{ $meeting->subject }}</a></li>--}}
            {{--<li class="breadcrumb-item active">Agenda Items</li>--}}
        {{--</ol>--}}

        @can('facilitate', $group)
            <a href="{{ route('meetings.agendas.create', $meeting->id) }}" class="btn btn-primary pull-right">
                <i class="fa fa-plus"></i>
                Add agenda item
            </a>
        @endcan

        <h1>
            Agenda
            <small><a href="{{ route('groups.meetings.index', ['group'=>$group->slug]) }}"> {{ $meeting->subject }}</a></small>
        </h1>

        <p class="lead text-right">
            Time remaining to budget:

            <span class="{{ $meeting->isRemainingTimeNegative() ? 'text-danger' : 'text-success' }}">
                    <b>{{ $meeting->remainingTimeToSchedule() }}</b> minutes
                </span>
        </p>

        @if ($agendas->count())
            <table class="table">
                <tr>
                    <th>Agenda Item</th>
                    <th>Duration</th>
                    <th class="text-center">Participants</th>
                    <th class="text-center">Order</th>
                    <th>&nbsp;</th>
                </tr>

                @foreach ($agendas as $agenda)
                    <tr>
                        <td>
                            {{ $agenda->name }}
                        </td>
                        <td>
                            {{ $agenda->duration }} minutes
                        </td>
                        <td class="text-center">
                            @if ($agenda->is_facilitator_only)
                                Facilitator only
                            @else
                                All members
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $agenda->order }}
                        </td>
                        <td class="text-right">
                            @can('facilitate', $group)
                                <a href="{{ route('meetings.agendas.edit', [$meeting->id, $agenda->id]) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <delete-record-button
                                        action="{{ route('meetings.agendas.destroy', [$meeting->id, $agenda->id]) }}">
                                    <button type="button" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </delete-record-button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </table>

            {{ $agendas->links() }}
        @else
            <p class="text-center">This meeting current has no agenda set.</p>
        @endif
    </div>
@endsection