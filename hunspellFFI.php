<?php

namespace glex\hunspellFFI;

use FFI;

interface ihunspell {}

class hunspellFFI {

    const SOFILE     = '/lib/x86_64-linux-gnu/libhunspell.so';
    const HEADER_DEF = 'typedef struct Hunhandle Hunhandle;
Hunhandle *Hunspell_create(char *affpath, char *dpath);
Hunhandle *Hunspell_create_key(char *affpath, char *dpath, char *key);
void Hunspell_destroy(Hunhandle *pHunspell);
int Hunspell_add_dic(Hunhandle *pHunspell, char *dpath);
int Hunspell_spell(Hunhandle *pHunspell, char *);
char *Hunspell_get_dic_encoding(Hunhandle *pHunspell);
int Hunspell_suggest(Hunhandle *pHunspell, char ***slst, char *word);
int Hunspell_analyze(Hunhandle *pHunspell, char ***slst, char *word);
int Hunspell_stem(Hunhandle *pHunspell, char ***slst, char *word);
int Hunspell_stem2(Hunhandle *pHunspell, char ***slst, char **desc, int n);
int Hunspell_generate(Hunhandle *pHunspell, char ***slst, char *word, char *word2);
int Hunspell_generate2(Hunhandle *pHunspell, char ***slst, char *word, char **desc, int n);
int Hunspell_add(Hunhandle *pHunspell, char *word);
int Hunspell_add_with_affix(Hunhandle *pHunspell, char *word, char *example);
int Hunspell_remove(Hunhandle *pHunspell, char *word);
void Hunspell_free_list(Hunhandle *pHunspell, char ***slst, int n);
';


    private FFI $ffi;


    public function __construct(string $pathToSoFile = self::SOFILE) {
        $this->ffi = FFI::cdef(self::HEADER_DEF, $pathToSoFile);
    }


    public function cast(ihunspell $from, string $to): ihunspell {
        if (!is_a($to, ihunspell::class)) {
            throw new \LogicException("Cannot cast to a non-wrapper type");
        }
        return new $to($this->ffi->cast($to::getType(), $from->getData()));
    }


    public function makeArray(string $class, array $elements) {
        $type = $class::getType();
        if (substr($type, -1) !== "*") {
            throw new \LogicException("Attempting to make a non-pointer element into an array");
        }
        $cdata = $this->ffi->new(substr($type, 0, -1)."[".count($elements)."]");
        foreach ($elements as $key => $raw) {
            $cdata[$key] = $raw === null ? null : $raw->getData();
        }
        return new $class($cdata);
    }


    public function sizeof($classOrObject): int {
        if (is_object($classOrObject) && $classOrObject instanceof ihunspell) {
            return $this->ffi::sizeof($classOrObject->getData());
        }
        elseif (is_a($classOrObject, ihunspell::class)) {
            return $this->ffi::sizeof($this->ffi->type($classOrObject::getType()));
        }
        else {
            throw new \LogicException("Unknown class/object passed to sizeof()");
        }
    }


    public function getFFI(): FFI {
        return $this->ffi;
    }


    public function __get(string $name) {
        switch ($name) {
            default: return $this->ffi->$name;
        }
    }


    public function Hunspell_create(?string $p0, ?string $p1): ?Hunhandle_ptr {
        $result = $this->ffi->Hunspell_create($p0, $p1);
        return $result === null ? null : new Hunhandle_ptr($result);
    }


    public function Hunspell_create_key(?string $p0, ?string $p1, ?string $p2): ?Hunhandle_ptr {
        $result = $this->ffi->Hunspell_create_key($p0, $p1, $p2);
        return $result === null ? null : new Hunhandle_ptr($result);
    }


    public function Hunspell_destroy(?Hunhandle_ptr $p0): void {
        $this->ffi->Hunspell_destroy($p0 === null ? null : $p0->getData());
    }


    public function Hunspell_add_dic(?Hunhandle_ptr $p0, ?string $p1): ?int {
        $result = $this->ffi->Hunspell_add_dic($p0 === null ? null : $p0->getData(), $p1);
        return $result;
    }


    public function Hunspell_spell(?Hunhandle_ptr $p0, ?string $p1): ?int {
        $result = $this->ffi->Hunspell_spell($p0 === null ? null : $p0->getData(), $p1);
        return $result;
    }


    public function Hunspell_get_dic_encoding(?Hunhandle_ptr $p0): ?string_ {
        $result = $this->ffi->Hunspell_get_dic_encoding($p0 === null ? null : $p0->getData());
        return $result === null ? null : new string_($result);
    }


    public function Hunspell_suggest(?Hunhandle_ptr $p0, ?string_ptr_ptr $p1, ?string $p2): ?int {
        $result = $this->ffi->Hunspell_suggest($p0 === null ? null : $p0->getData(), $p1 === null ? null : $p1->getData(), $p2);
        return $result;
    }


    public function Hunspell_analyze(?Hunhandle_ptr $p0, ?string_ptr_ptr $p1, ?string $p2): ?int {
        $result = $this->ffi->Hunspell_analyze($p0 === null ? null : $p0->getData(), $p1 === null ? null : $p1->getData(), $p2);
        return $result;
    }


    public function Hunspell_stem(?Hunhandle_ptr $p0, ?string_ptr_ptr $p1, ?string $p2): ?int {
        $result = $this->ffi->Hunspell_stem($p0 === null ? null : $p0->getData(), $p1 === null ? null : $p1->getData(), $p2);
        return $result;
    }


    public function Hunspell_stem2(?Hunhandle_ptr $p0, ?string_ptr_ptr $p1, ?string_ptr $p2, ?int $p3): ?int {
        $result = $this->ffi->Hunspell_stem2($p0 === null ? null : $p0->getData(), $p1 === null ? null : $p1->getData(), $p2 === null ? null : $p2->getData(), $p3);
        return $result;
    }


    public function Hunspell_generate(?Hunhandle_ptr $p0, ?string_ptr_ptr $p1, ?string $p2, ?string $p3): ?int {
        $result = $this->ffi->Hunspell_generate($p0 === null ? null : $p0->getData(), $p1 === null ? null : $p1->getData(), $p2, $p3);
        return $result;
    }


    public function Hunspell_generate2(?Hunhandle_ptr $p0, ?string_ptr_ptr $p1, ?string $p2, ?string_ptr $p3, ?int $p4): ?int {
        $result = $this->ffi->Hunspell_generate2($p0 === null ? null : $p0->getData(), $p1 === null ? null : $p1->getData(), $p2, $p3 === null ? null : $p3->getData(), $p4);
        return $result;
    }


    public function Hunspell_add(?Hunhandle_ptr $p0, ?string $p1): ?int {
        $result = $this->ffi->Hunspell_add($p0 === null ? null : $p0->getData(), $p1);
        return $result;
    }


    public function Hunspell_add_with_affix(?Hunhandle_ptr $p0, ?string $p1, ?string $p2): ?int {
        $result = $this->ffi->Hunspell_add_with_affix($p0 === null ? null : $p0->getData(), $p1, $p2);
        return $result;
    }


    public function Hunspell_remove(?Hunhandle_ptr $p0, ?string $p1): ?int {
        $result = $this->ffi->Hunspell_remove($p0 === null ? null : $p0->getData(), $p1);
        return $result;
    }


    public function Hunspell_free_list(?Hunhandle_ptr $p0, ?string_ptr_ptr $p1, ?int $p2): void {
        $this->ffi->Hunspell_free_list($p0 === null ? null : $p0->getData(), $p1 === null ? null : $p1->getData(), $p2);
    }


}


class string_ implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(string_ $other): bool { return $this->data == $other->data; }
    public function addr(): string_ptr { return new string_ptr(FFI::addr($this->data)); }
    public function toString(?int $length = null): string { return $length === null ? FFI::string($this->data) : FFI::string($this->data, $length); }
    public static function getType(): string { return 'char*'; }
}
class string_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(string_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): string_ptr_ptr { return new string_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): string_ { return new string_($this->data[$n]); }
    public static function getType(): string { return 'char**'; }
}
class string_ptr_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(string_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): string_ptr_ptr_ptr { return new string_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): string_ptr { return new string_ptr($this->data[$n]); }
    public static function getType(): string { return 'char***'; }
}
class string_ptr_ptr_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(string_ptr_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): string_ptr_ptr_ptr_ptr { return new string_ptr_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): string_ptr_ptr { return new string_ptr_ptr($this->data[$n]); }
    public static function getType(): string { return 'char****'; }
}
class int_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(int_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): int_ptr_ptr { return new int_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): int { return new int($this->data[$n]); }
    public static function getType(): string { return 'int*'; }
}
class int_ptr_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(int_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): int_ptr_ptr_ptr { return new int_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): int_ptr { return new int_ptr($this->data[$n]); }
    public static function getType(): string { return 'int**'; }
}
class int_ptr_ptr_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(int_ptr_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): int_ptr_ptr_ptr_ptr { return new int_ptr_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): int_ptr_ptr { return new int_ptr_ptr($this->data[$n]); }
    public static function getType(): string { return 'int***'; }
}
class void_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(void_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): void_ptr_ptr { return new void_ptr_ptr(FFI::addr($this->data)); }
    public static function getType(): string { return 'void*'; }
}
class void_ptr_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(void_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): void_ptr_ptr_ptr { return new void_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): void_ptr { return new void_ptr($this->data[$n]); }
    public static function getType(): string { return 'void**'; }
}
class void_ptr_ptr_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(void_ptr_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): void_ptr_ptr_ptr_ptr { return new void_ptr_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): void_ptr_ptr { return new void_ptr_ptr($this->data[$n]); }
    public static function getType(): string { return 'void***'; }
}
class Hunhandle implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(Hunhandle $other): bool { return $this->data == $other->data; }
    public function addr(): Hunhandle_ptr { return new Hunhandle_ptr(FFI::addr($this->data)); }
    public static function getType(): string { return 'Hunhandle'; }
}
class Hunhandle_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(Hunhandle_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): Hunhandle_ptr_ptr { return new Hunhandle_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): Hunhandle { return new Hunhandle($this->data[$n]); }
    public static function getType(): string { return 'Hunhandle*'; }
}
class Hunhandle_ptr_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(Hunhandle_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): Hunhandle_ptr_ptr_ptr { return new Hunhandle_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): Hunhandle_ptr { return new Hunhandle_ptr($this->data[$n]); }
    public static function getType(): string { return 'Hunhandle**'; }
}
class Hunhandle_ptr_ptr_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(Hunhandle_ptr_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): Hunhandle_ptr_ptr_ptr_ptr { return new Hunhandle_ptr_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): Hunhandle_ptr_ptr { return new Hunhandle_ptr_ptr($this->data[$n]); }
    public static function getType(): string { return 'Hunhandle***'; }
}
class Hunhandle_ptr_ptr_ptr_ptr implements ihunspell {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(Hunhandle_ptr_ptr_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): Hunhandle_ptr_ptr_ptr_ptr_ptr { return new Hunhandle_ptr_ptr_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): Hunhandle_ptr_ptr_ptr { return new Hunhandle_ptr_ptr_ptr($this->data[$n]); }
    public static function getType(): string { return 'Hunhandle****'; }
}