<?php

namespace HomeownerParser;

use League\Csv\Reader;

class Parser {
    public function parseCsv(string $filePath): array {
        $reader = Reader::createFromPath($filePath, 'r');
        $reader->setHeaderOffset(0);

        $records = $reader->getRecords();
        $people = [];

        foreach ($records as $record) {
            if (isset($record['homeowner']) && !empty($record['homeowner'])) {
                $people = array_merge($people, $this->parseName($record['homeowner']));
            }
        }

        return $people;
    }

    private function parseName(string $name): array {
        $result = [];
        $titles = '(Mr|Mrs|Miss|Ms|Dr|Prof|Mister)';

        // Handle "Dr & Mrs Joe Bloggs" (shared last name)
        if (preg_match('/^' . $titles . '\s*&\s*' . $titles . '\s+([A-Za-z]+)\s+([A-Za-z\-]+)$/', $name, $matches)) {
            $result[] = [
                'title' => $matches[1],
                'first_name' => null,
                'initial' => null,
                'last_name' => $matches[4],
            ];
            $result[] = [
                'title' => $matches[2],
                'first_name' => $matches[3],
                'initial' => null,
                'last_name' => $matches[4],
            ];
        }

        // Handle "Mr Tom Staff and Mr John Doe"
        elseif (preg_match('/^' . $titles . '\s+([A-Za-z]+)\s+([A-Za-z]+)\s+and\s+' . $titles . '\s+([A-Za-z]+)\s+([A-Za-z\-]+)$/', $name, $matches)) {
            $result[] = [
                'title' => $matches[1],
                'first_name' => $matches[2],
                'initial' => null,
                'last_name' => $matches[3],
            ];
            $result[] = [
                'title' => $matches[4],
                'first_name' => $matches[5],
                'initial' => null,
                'last_name' => $matches[6],
            ];
        }

        // Handle "Mrs Faye Hughes-Eastwood" (hyphenated last name)
        elseif (preg_match('/^' . $titles . '\s+([A-Za-z]+)\s+([A-Za-z\-]+)$/', $name, $matches)) {
            $result[] = [
                'title' => $matches[1],
                'first_name' => $matches[2],
                'initial' => null,
                'last_name' => $matches[3],
            ];
        }

        // Handle "Mr & Mrs Smith" or "Mr and Mrs Smith"
        elseif (preg_match('/^' . $titles . '\s*&\s*' . $titles . '\s+([A-Za-z\-]+)$/', $name, $matches) ||
                preg_match('/^' . $titles . '\s+and\s+' . $titles . '\s+([A-Za-z\-]+)$/', $name, $matches)) {
            $result[] = [
                'title' => $matches[1],
                'first_name' => null,
                'initial' => null,
                'last_name' => $matches[3],
            ];
            $result[] = [
                'title' => $matches[2],
                'first_name' => null,
                'initial' => null,
                'last_name' => $matches[3],
            ];
        }

        // Handle "Mr J. Smith"
        elseif (preg_match('/^' . $titles . '\s+([A-Z])\.\s+([A-Za-z\-]+)$/', $name, $matches)) {
            $result[] = [
                'title' => $matches[1],
                'first_name' => null,
                'initial' => $matches[2],
                'last_name' => $matches[3],
            ];
        }

        // Handle "Mr John Smith" or "Mister John Smith"
        elseif (preg_match('/^' . $titles . '\s+([A-Za-z]+)\s+([A-Za-z\-]+)$/', $name, $matches)) {
            $result[] = [
                'title' => $matches[1],
                'first_name' => $matches[2],
                'initial' => null,
                'last_name' => $matches[3],
            ];
        }

        return $result;
    }
}