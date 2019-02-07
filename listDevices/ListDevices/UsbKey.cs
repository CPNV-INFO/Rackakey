using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ListDevices
{
    class UsbKey
    {
        private string name;
        private string uuid;
        private UInt64 freeSpaceInBytes;
        private int status_id;
        private int rack_number;
        private int port_number;
        private string createtd_at;
        private string updated_at;


        public string Name { get{ return name; } }
        public string Uuid { get { return uuid; } }
        public UInt64 FreeSpaceInBytes { get { return freeSpaceInBytes; } }
        public int Status_id { get { return status_id; } }
        public int Rack_number { get { return rack_number; } }
        public int Port_number { get { return port_number; } }
        public string Created_at { get { return createtd_at;  } }
        public string Updated_at { get { return updated_at; } }


        public UsbKey(string name, string uuid, UInt64 freeSpaceInBytes, string createtd_at, string updated_at = null, int status_id = (int)Status.Disponible, int rack_number = 0, int port_number = 0)
        {
            this.name = name;
            this.uuid = uuid;
            this.freeSpaceInBytes = freeSpaceInBytes;
            this.status_id = status_id;
            this.rack_number = rack_number;
            this.port_number = port_number;
            this.createtd_at = createtd_at;
            this.updated_at = updated_at;
        }

    }
}
